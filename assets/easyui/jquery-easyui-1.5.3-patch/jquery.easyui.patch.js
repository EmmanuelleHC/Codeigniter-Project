/**
 * The Patch for jQuery EasyUI 1.5.3
 */

(function($){
	function setSize(target, param){
		var state = $.data(target, 'panel');
		var opts = state.options;
		var panel = state.panel;
		var pheader = panel.children('.panel-header');
		var pbody = panel.children('.panel-body');
		var pfooter = panel.children('.panel-footer');
		var isHorizontal = (opts.halign=='left' || opts.halign=='right');
		
		if (param){
			$.extend(opts, {
				width: param.width,
				height: param.height,
				minWidth: param.minWidth,
				maxWidth: param.maxWidth,
				minHeight: param.minHeight,
				maxHeight: param.maxHeight,
				left: param.left,
				top: param.top
			});
			opts.hasResized = false;
		}
		
		var oldWidth = panel.outerWidth();
		var oldHeight = panel.outerHeight();
		panel._size(opts);
		var newWidth = panel.outerWidth();
		var newHeight = panel.outerHeight();
		if (opts.hasResized && (oldWidth == newWidth && oldHeight == newHeight)){
			return;
		}
		opts.hasResized = true;
		// pheader.add(pbody)._outerWidth(panel.width());
		if (!isHorizontal){
			pheader._outerWidth(panel.width());
		}
		pbody._outerWidth(panel.width());
		if (!isNaN(parseInt(opts.height))){
			if (isHorizontal){
				if (opts.header){
					var headerWidth = $(opts.header)._outerWidth();
				} else {
					pheader.css('width','');
					var headerWidth = pheader._outerWidth();
				}
				var ptitle = pheader.find('.panel-title');
				headerWidth += Math.min(ptitle._outerWidth(),ptitle._outerHeight());
				var headerHeight = panel.height();
				pheader._outerWidth(headerWidth)._outerHeight(headerHeight);
				ptitle._outerWidth(pheader.height());
				pbody._outerWidth(panel.width()-headerWidth-pfooter._outerWidth())._outerHeight(headerHeight);
				pfooter._outerHeight(headerHeight);
				pbody.css({left:'',right:''}).css(opts.halign, (pheader.position()[opts.halign]+headerWidth)+'px');
				opts.panelCssWidth = panel.css('width');
				if (opts.collapsed){
					panel._outerWidth(headerWidth+pfooter._outerWidth());
				}
			} else {
				// pheader.css('height','');
				pbody._outerHeight(panel.height() - pheader._outerHeight() - pfooter._outerHeight());
			}
		} else {
			pbody.css('height', '');
			var min = $.parser.parseValue('minHeight', opts.minHeight, panel.parent());
			var max = $.parser.parseValue('maxHeight', opts.maxHeight, panel.parent());
			var distance = pheader._outerHeight() + pfooter._outerHeight() + panel._outerHeight() - panel.height();
			pbody._size('minHeight', min ? (min - distance) : '');
			pbody._size('maxHeight', max ? (max - distance) : '');
		}
		panel.css({
			height: (isHorizontal?undefined:''),
			minHeight: '',
			maxHeight: '',
			left: opts.left,
			top: opts.top
		});
		
		opts.onResize.apply(target, [opts.width, opts.height]);
		
		$(target).panel('doLayout');
	}
	function loadData(target, params){
		var state = $.data(target, 'panel');
		var opts = state.options;
		if (param){opts.queryParams = params}
		if (!opts.href){return;}
		if (!state.isLoaded || !opts.cache){
			var param = $.extend({}, opts.queryParams);
			if (opts.onBeforeLoad.call(target, param) == false){return}
			state.isLoaded = false;
			// $(target).panel('clear');
			if (opts.loadingMessage){
				$(target).panel('clear');
				$(target).html($('<div class="panel-loading"></div>').html(opts.loadingMessage));
			}
			opts.loader.call(target, param, function(data){
				var content = opts.extractor.call(target, data);
				$(target).panel('clear');
				$(target).html(content);
				$.parser.parse($(target));
				opts.onLoad.apply(target, arguments);
				state.isLoaded = true;
			}, function(){
				opts.onLoadError.apply(target, arguments);
			});
		}
	}
	function openPanel(target, forceOpen){
		var state = $.data(target, 'panel');
		var opts = state.options;
		var panel = state.panel;
		
		if (forceOpen != true){
			if (opts.onBeforeOpen.call(target) == false) return;
		}
		panel.stop(true, true);
		if ($.isFunction(opts.openAnimation)){
			opts.openAnimation.call(target, cb);
		} else {
			switch(opts.openAnimation){
			case 'slide':
				panel.slideDown(opts.openDuration, cb);
				break;
			case 'fade':
				panel.fadeIn(opts.openDuration, cb);
				break;
			case 'show':
				panel.show(opts.openDuration, cb);
				break;
			default:
				panel.show();
				cb();
			}
		}
		
		function cb(){
			opts.closed = false;
			opts.minimized = false;
			var tool = panel.children('.panel-header').find('a.panel-tool-restore');
			if (tool.length){
				opts.maximized = true;
			}
			opts.onOpen.call(target);
			
			if (opts.maximized == true) {
				opts.maximized = false;
				maximizePanel(target);
			}
			if (opts.collapsed == true) {
				opts.collapsed = false;
				collapsePanel(target);
			}
			if (!opts.collapsed){
				if (opts.href && (!state.isLoaded || !opts.cache)){
					loadData(target);
					$(target).panel('doLayout', true);
				}
			}
		}
	}
	$.extend($.fn.panel.methods, {
		resize: function(jq, param){
			return jq.each(function(){
				setSize(this, param);
			});
		},
		open: function(jq, forceOpen){
			return jq.each(function(){
				openPanel(this, forceOpen);
			});
		}
	})
})(jQuery);

(function($){
	function setEvents(target){
		var opts = $(target).combo('options');
		var p = $(target).combo('panel');
		p.unbind('.combo');
		for(var event in opts.panelEvents){
			p.bind(event+'.combo', {target:target}, opts.panelEvents[event]);
		}
	}

	var plugin = $.fn.combo;
	$.fn.combo = function(options, param){
		if (typeof options == 'string'){
			return plugin.call(this, options, param);
		} else {
			return this.each(function(){
				plugin.call($(this), options, param);
				setEvents(this);
			});
		}
	}
	$.fn.combo.defaults = plugin.defaults;
	$.fn.combo.methods = plugin.methods;
	$.fn.combo.parseOptions = plugin.parseOptions;
	$.extend($.fn.combo.defaults, {
		panelEvents: {
			mousedown: function(e){
				e.preventDefault();
				e.stopPropagation();
			}
		}
	});
})(jQuery);

(function($){
	function setValues(target, values, remainText){
		var opts = $.data(target, 'combobox').options;
		var panel = $(target).combo('panel');
		
		if (!$.isArray(values)){
			values = values.split(opts.separator);
		}
		if (!opts.multiple){
			values = values.length ? [values[0]] : [''];
		}

		// unselect the old rows
		var oldValues = $(target).combo('getValues');
		if (panel.is(':visible')){
			panel.find('.combobox-item-selected').each(function(){
				var row = opts.finder.getRow(target, $(this));
				if (row){
					if ($.easyui.indexOfArray(oldValues, row[opts.valueField]) == -1){
						$(this).removeClass('combobox-item-selected');
					}
				}
			});
		}
		$.map(oldValues, function(v){
			if ($.easyui.indexOfArray(values, v) == -1){
				var el = opts.finder.getEl(target, v);
				if (el.hasClass('combobox-item-selected')){
					el.removeClass('combobox-item-selected');
					opts.onUnselect.call(target, opts.finder.getRow(target, v));
				}
			}
		});

		var theRow = null;
		var vv = [], ss = [];
		for(var i=0; i<values.length; i++){
			var v = values[i];
			var s = v;
			var row = opts.finder.getRow(target, v);
			if (row){
				s = row[opts.textField];
				theRow = row;
				var el = opts.finder.getEl(target, v);
				if (!el.hasClass('combobox-item-selected')){
					el.addClass('combobox-item-selected');
					opts.onSelect.call(target, row);
				}
			} else {
				s = findText(v, opts.mappingRows) || v;
			}
			vv.push(v);
			ss.push(s);
		}

		if (!remainText){
			$(target).combo('setText', ss.join(opts.separator));
		}
		if (opts.showItemIcon){
			var tb = $(target).combobox('textbox');
			tb.removeClass('textbox-bgicon ' + opts.textboxIconCls);
			if (theRow && theRow.iconCls){
				tb.addClass('textbox-bgicon ' + theRow.iconCls);
				opts.textboxIconCls = theRow.iconCls;
			}
		}
		$(target).combo('setValues', vv);
		panel.triggerHandler('scroll');	// trigger the group sticking

		function findText(value, a){
			var item = $.easyui.getArrayItem(a, opts.valueField, value);
			return item ? item[opts.textField] : undefined;
		}
	}

	function fix(target){
		var opts = $(target).combobox('options');
		var vv = $(target).combobox('getValues');
		$(target).combobox('setValues', vv);
		var onLoadSuccess = opts.onLoadSuccess;
		opts.onLoadSuccess = function(data){
			onLoadSuccess.call(target, data);
			var vv = $(target).combobox('getValues');
			var remainText = $(target).combobox('textbox').is(':focus');
			if (opts.multiple){
				setValues(target, vv, remainText);
			} else {
				setValues(target, vv.length ? [vv[vv.length-1]] : [], remainText);
			}
		}
		$(target).combobox('panel').unbind('.combobox');
	}

	function select(target, value, remainText){
		var opts = $.data(target, 'combobox').options;
		var values = $(target).combo('getValues');
		if ($.inArray(value+'', values) == -1){
			if (opts.multiple){
				values.push(value);
			} else {
				values = [value];
			}
			setValues(target, values, remainText);
		}
	}
	function doQuery(target, q){
		var state = $.data(target, 'combobox');
		var opts = state.options;

		var highlightItem = $();
		var qq = opts.multiple ? q.split(opts.separator) : [q];
		if (opts.mode == 'remote'){
			// _setValues(qq);
			// request(target, null, {q:q}, true);
		} else {
			var panel = $(target).combo('panel');
			panel.find('.combobox-item-hover').removeClass('combobox-item-hover');
			panel.find('.combobox-item,.combobox-group').hide();
			var data = state.data;
			var vv = [];
			$.map(qq, function(q){
				// q = $.trim(q);
				var value = $.trim(q);
				var group = undefined;
				highlightItem = $();
				for(var i=0; i<data.length; i++){
					var row = data[i];
					if (opts.filter.call(target, q, row)){
						var v = row[opts.valueField];
						var s = row[opts.textField];
						var g = row[opts.groupField];
						var item = opts.finder.getEl(target, v).show();
						if ($.trim(s).toLowerCase() == $.trim(q).toLowerCase()){
							value = v;
							if (opts.reversed){
								highlightItem = item;
							} else {
								select(target, v, true);
							}
						}
						if (opts.groupField && group != g){
							opts.finder.getGroupEl(target, g).show();
							group = g;
						}
					}
				}
				vv.push(value);
			});
			_setValues(vv);
		}
		function _setValues(vv){
			if (opts.reversed){
				highlightItem.addClass('combobox-item-hover');
			} else {
				setValues(target, opts.multiple ? ($.trim(q)?vv:[]) : vv, true);
			}
		}
	}

	var plugin = $.fn.combobox;
	$.fn.combobox = function(options, param){
		if (typeof options == 'string'){
			return plugin.call(this, options, param);
		} else {
			return this.each(function(){
				plugin.call($(this), options, param);
				fix(this);
			});
		}
	};
	$.fn.combobox.defaults = plugin.defaults;
	$.fn.combobox.methods = plugin.methods;
	$.fn.combobox.parseOptions = plugin.parseOptions;
	$.fn.combobox.parseData = plugin.parseData;
	$.extend($.fn.combobox.defaults, {
		unselectedValues: [],
		mappingRows: [],
		filter: function(q, row){
			q = $.trim(q);
			var opts = $(this).combobox('options');
			return row[opts.textField].toLowerCase().indexOf(q.toLowerCase()) >= 0;
		}
	});
	var oldQuery = $.fn.combobox.defaults.keyHandler.query;
	$.extend($.fn.combobox.defaults.keyHandler, {
		query: function(q,e){
			var opts = $(this).combobox('options');
			if (opts.mode == 'remote'){
				oldQuery.call(this, q, e);
			} else {
				doQuery(this, q);
			}
		}
	});
	$.extend($.fn.combobox.defaults.panelEvents, {
		mousedown: function(e){
			e.preventDefault();
			e.stopPropagation();
		}
	});
	$.extend($.fn.combobox.methods, {
		setValues: function(jq, values){
			return jq.each(function(){
				var opts = $(this).combobox('options');
				if ($.isArray(values)){
					values = $.map(values, function(value){
						if (value && typeof value == 'object'){
							$.easyui.addArrayItem(opts.mappingRows, opts.valueField, value);
							return value[opts.valueField];
						} else {
							return value;
						}
					});
				}
				setValues(this, values);
			});
		},
		setValue: function(jq, value){
			return jq.each(function(){
				$(this).combobox('setValues', $.isArray(value)?value:[value]);
			});
		}
	});
})(jQuery);

(function($){
	function doQuery(target, q){
		var state = $.data(target, 'combotreegrid');
		var opts = state.options;
		var grid = state.grid;
		state.remainText = true;

		grid.treegrid('clearSelections').treegrid('clearChecked').treegrid('highlightRow', -1);
		var qq = opts.multiple ? q.split(opts.separator) : [q];
		qq = $.grep(qq, function(q){return $.trim(q)!='';});
		if (opts.mode == 'remote'){
			_setValues(qq);
			grid.treegrid('load', $.extend({}, opts.queryParams, {q:q}));
		} else if (q){
			var data = grid.treegrid('getData');
			var vv = [];
			$.map(qq, function(q){
				q = $.trim(q);
				if (q){
					var v = undefined;
					$.easyui.forEach(data, true, function(row){
						if (q.toLowerCase() == String(row[opts.treeField]).toLowerCase()){
							v = row[opts.idField];
							return false;
						} else if (opts.filter.call(target, q, row)){
							grid.treegrid('expandTo', row[opts.idField]);
							grid.treegrid('highlightRow', row[opts.idField]);
							return false;
						}
					});
					if (v == undefined){
						$.easyui.forEach(opts.mappingRows, false, function(row){
							if (q.toLowerCase() == String(row[opts.treeField])){
								v = row[opts.idField];
								return false;
							}
						})
					}
					if (v != undefined){
						vv.push(v);
					} else {
						vv.push(q);
					}
				}
			});
			_setValues(vv);
			state.remainText = false;
		}
		function _setValues(vv){
			if (!opts.reversed){
				$(target).combotreegrid('setValues', vv);
			}
		}
	}
	function doEnter(target){
		var state = $.data(target, 'combotreegrid');
		var opts = state.options;
		var grid = state.grid;
		var tr = opts.finder.getTr(grid[0], null, 'highlight');
		state.remainText = false;
		if (tr.length){
			var id = tr.attr('node-id');
			if (opts.multiple){
				if (tr.hasClass('datagrid-row-selected')){
					grid.treegrid('uncheckNode', id);
				} else {
					grid.treegrid('checkNode', id);
				}
			} else {
				grid.treegrid('selectRow', id);
			}
		}
		var vv = [];
		if (opts.multiple){
			$.map(grid.treegrid('getCheckedNodes'), function(row){
				vv.push(row[opts.idField]);
			});
		} else {
			var row = grid.treegrid('getSelected');
			if (row){
				vv.push(row[opts.idField]);
			}
		}
		$.map(opts.unselectedValues, function(v){
			if ($.easyui.indexOfArray(opts.mappingRows, opts.idField, v) >= 0){
				$.easyui.addArrayItem(vv, v);
			}
		});
		$(target).combotreegrid('setValues', vv);
		if (!opts.multiple){
			$(target).combotreegrid('hidePanel');
		}
	}

	$.extend($.fn.combotreegrid.defaults.keyHandler, {
		enter: function(e){doEnter(this)},
		query: function(q,e){doQuery(this, q)}
	});
})(jQuery);

(function($){
	$.extend($.fn.propertygrid.defaults.groupView, {
		insertRow: function(target, index, row){
			var state = $.data(target, 'datagrid');
			var opts = state.options;
			var dc = state.dc;
			var group = null;
			var groupIndex;
			
			if (!state.data.rows.length){
				var originalRows = state.originalRows;
				var updatedRows = state.updatedRows;
				var insertedRows = state.insertedRows;
				var deletedRows = state.deletedRows;
				$(target).datagrid('loadData', [row]);
				state.originalRows = $.extend([],originalRows);
				state.updatedRows = $.extend([],updatedRows);
				state.insertedRows = $.extend([],insertedRows);
				state.deletedRows = $.extend([],deletedRows);
				state.insertedRows.push(row);
				return;
			}
			
			for(var i=0; i<this.groups.length; i++){
				if (this.groups[i].value == row[opts.groupField]){
					group = this.groups[i];
					groupIndex = i;
					break;
				}
			}
			if (group){
				if (index == undefined || index == null){
					index = state.data.rows.length;
				}
				if (index < group.startIndex){
					index = group.startIndex;
				} else if (index > group.startIndex + group.rows.length){
					index = group.startIndex + group.rows.length;
				}
				$.fn.datagrid.defaults.view.insertRow.call(this, target, index, row);
				
				if (index >= group.startIndex + group.rows.length){
					_moveTr(index, true);
					_moveTr(index, false);
				}
				group.rows.splice(index - group.startIndex, 0, row);
			} else {
				group = {
					value: row[opts.groupField],
					rows: [row],
					startIndex: state.data.rows.length
				}
				groupIndex = this.groups.length;
				dc.body1.append(this.renderGroup.call(this, target, groupIndex, group, true));
				dc.body2.append(this.renderGroup.call(this, target, groupIndex, group, false));
				this.groups.push(group);
				state.data.rows.push(row);
			}
			
			this.refreshGroupTitle(target, groupIndex);
			
			function _moveTr(index,frozen){
				var serno = frozen?1:2;
				var prevTr = opts.finder.getTr(target, index-1, 'body', serno);
				var tr = opts.finder.getTr(target, index, 'body', serno);
				tr.insertAfter(prevTr);
			}
		}

	})
})(jQuery);

(function($){
	$.extend($.fn.datebox.defaults, {
		buttons:[{
			text: function(target){return $(target).datebox('options').currentText;},
			handler: function(target){
				var opts = $(target).datebox('options');
				var now = new Date();
				var current = new Date(now.getFullYear(), now.getMonth(), now.getDate());
				$(target).datebox('calendar').calendar({
					year:current.getFullYear(),
					month:current.getMonth()+1,
					current:current
				});
				opts.onSelect.call(target, current);
				$(target).datebox('setValue', opts.formatter.call(target, current));
				$(target).combo('hidePanel');
			}
		},{
			text: function(target){return $(target).datebox('options').closeText;},
			handler: function(target){
				$(this).closest('div.combo-panel').panel('close');
			}
		}]
	});
})(jQuery);

(function($){
	$.extend($.fn.searchbox.methods, {
		selectName: function(jq, name){
			return jq.each(function(){
				var menu = $.data(this, 'searchbox').menu;
				if (menu){
					menu.children('div.menu-item').each(function(){
						var item = menu.menu('getItem', this);
						if (item.name == name){
							$(this).trigger('click');
							return false;
						}
					});
				}
			});
		}
	});
})(jQuery);
