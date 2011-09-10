/**
 * Dialog
 *
 * @author      Roland Franssen <franssen.roland@gmail.com>
 * @license     MIT
 * @version     2.1
 **/

var Dialogs = {
	Lang:{
		close:   '&nbsp;&times;&nbsp;',
		prev:    '&laquo; Previous',
		next:    'Next &raquo;',
		loading: 'Loading...',
		ok:      'OK',
		yes:     'Yes',
		no:      'No'
	},
	Default:{
		handle:         null,                    // css rule | element | null
		autoOpen:       false,                   // true | false
		background:     ['#000', '#fff'],        // array
		width:          'auto',                  // auto | max | integer
		height:         'auto',                  // auto | max | integer
		minWidth:       null,                    // null | pixel value
		minHeight:      null,                    // null | pixel value
		innerScroll:    true,                    // true | false
		opacity:        .75,                     // float | false
		margin:         10,                      // integer
		padding:        10,                      // integer
		title:          null,                    // string | null
		className:      null,                    // string | null
		content:        null,                    // string | element | array | object | function
		iframe:         null,                    // string | null
		target:{
		  id:           null,                    // string | null
		  auto:         true                     // true | false
		},
		ajax:{
		  url:          null,                    // string | null
		  jsonTemplate: null,                    // interpolation template string | null
		  options:      {}                       // default ajax options
		},
		close:{
		  link:         true,                    // true | false
		  esc:          true,                    // true | false
		  overlay:      true                     // true | false
		},
		afterOpen:      Prototype.emptyFunction, // function
		afterClose:     Prototype.emptyFunction, // function
		afterClick:     Prototype.emptyFunction, // function
		afterIframeLoad:Prototype.emptyFunction  // function
	},
	Browser:{
		IE6:(Prototype.Browser.IE && parseInt(navigator.appVersion) == 4 && navigator.userAgent.toLowerCase().indexOf('msie 6.') != -1)
	}
};

Object.extend(Dialogs, {
	_exec:false,
	_open:false,
	_elements:{
		overlay:['div', 'dialog-overlay', 'fixed'],
		container:['div', 'dialog-container', 'fixed'],
		content:['div', 'dialog-content'],
		loading:['div', 'dialog-loading'],
		top:['div', 'dialog-top'],
		bottom:['div', 'dialog-bottom'],
		title:['span', 'dialog-title'],
		close:['a', 'dialog-close'],
		next:['a', null, 'next'],
		prev:['a', null, 'prev'],
		curr:['span', null, 'curr']
	},
	fix:{
		scroll:Dialogs.Browser.IE6,
		select:Dialogs.Browser.IE6
	},
	view:function(){
		var view = document.viewport,
		    dim  = view.getDimensions(),
			data = {width:dim.width, height:dim.height};
		if(Dialogs.fix.scroll){
			var scroll = view.getScrollOffsets();
			data.top  = scroll.top;
			data.left = scroll.left;
		}
		return data;
	},
	elm:function(elm){
		return Dialogs._elements[elm];
	},
	load:function(domready){
		if(!!Dialogs._exec) return;
		Dialogs._exec = true;
		var e = Dialogs._elements;
		for(var x in e){
			var d = e[x],
			    a = {style:'display:none'};
			if(d[1]) a['id'] = d[1];
			if(d[2]) a['className'] = d[2];
			switch(d[0]){
				case 'a': a['href'] = 'javascript:;'; break;
			}
			var el = new Element(d[0], a);
			if(Dialogs.Lang[x]) el.update(Dialogs.Lang[x]);
			Dialogs._elements[x] = el;
		}
		var load = function(){
			var e = Dialogs._elements;
			$(document.body)
			.insert(e['overlay'])
			.insert(e['container']
				.insert(e['top']
					.insert(e['title'])
					.insert(e['close'])
				)
				.insert(e['content'])
				.insert(e['bottom']
					.insert(e['prev'])
					.insert(e['curr'])
					.insert(e['next'])
				)
			);
			if(Dialogs.Browser.IE6) e['top'].insert(new Element('div', {style:'clear:both'}));
		};
		if(!!domready) document.observe('dom:loaded', load);
		else load.call();
	},
	close:function(){
		[Dialogs.elm('title'), Dialogs.elm('content'), Dialogs.elm('curr')].invoke('update', '');
		for(var x in Dialogs._elements) Dialogs._elements[x].writeAttribute('style', 'display:none');
		Dialogs.elm('container').setStyle('left:-99999px;top:-99999px');
		if(Dialogs.fix.select)
			$$('select.dialog-hideselect').invoke('show').invoke('removeClassName', 'dialog-hideselect');
		Dialogs._open = false;
	},
	alert:function(s){
		var o = new Element('input', {value:Dialogs.Lang.ok, type:'button'}),
		    a = new Dialog({
				className:'alert',
				close:{link:false, esc:true},
				padding:20,
				content:function(){
					o.observe('click', Dialogs.close);
					return [s, '<br /><br />', o];
				},
				afterOpen:function(){
					o.focus();
				}
			});
		a.open();
	},
	confirm:function(s, y_call, n_call){
		var y = new Element('input', {value:Dialogs.Lang.yes, type:'button'}),
		    n = new Element('input', {value:Dialogs.Lang.no, type:'button'}),
		    c = new Dialog({
				className:'confirm',
				close:{link:false},
				padding:20,
				content:function(){
					y.observe('click', function(){
						if(Object.isFunction(y_call)) y_call();
						else Dialogs.close();
					});
					n.observe('click', function(){
						if(Object.isFunction(n_call)) n_call();
						else Dialogs.close();
					});
					return [s, '<br /><br />', y, n];
				},
				afterOpen:function(){
					y.focus();
				}
			});
		c.open();
	}
});
var Dialog = Class.create();
Dialog.prototype = {
	initialize:function(opt){
		this.opt = Object.extend(Object.clone(Dialogs.Default), opt || {});
		var c = this.opt.content;
		if(Object.isFunction(c))
			Object.extend(this.opt, {content:c()});
		c = this.opt.content;
		if(Object.isString(this.opt.target.id) || Object.isElement(this.opt.target.id)){
			var b = $(this.opt.target.id);
			Object.extend(this.opt, {content:b.innerHTML});
			if(this.opt.target.auto){
				var a = /#(.+)$/.exec(window.location);
				if(Object.isArray(a) && Object.isString(a[1])){
					a = a[1].split(',').last();
					if(a == b.identify()) this.open.bind(this).delay(1);
				}
			}
		}else if(Object.isHash(c))
			this.steps = {
				i:0,
				k:c.keys(),
				v:c.values(),
				m:c.size()
			};
		this.attachEvents();
		if(this.opt.autoOpen) this.open();
	},
	exec:function(bool){
		return Dialogs._open == this._open && Dialogs.elm('overlay').visible() && bool;
	},
	attachEvents:function(){
		Event.observe(window, 'resize', this.setDimensions.bindAsEventListener(this));
		if(Dialogs.fix.scroll)
			Event.observe(window, 'scroll', this.setScroll.bindAsEventListener(this));
		var handles = [];
		if(Object.isElement(this.opt.handle)) handles.push($(this.opt.handle));
		else if(Object.isArray(this.opt.handle)) this.opt.handle.each(function(handle){ handles.push($(handle)); });
		else if(Object.isString(this.opt.handle)) handles = $$(this.opt.handle);
		handles.invoke('show').invoke('observe', 'click', function(e){
			e.stop();
			if(Object.isFunction(this.opt.afterClick)) this.opt.afterClick(e);
			this.open();
		}.bindAsEventListener(this));
		Dialogs.elm('close').observe('click', function(){
			if(this.exec(this.opt.close.link)) this.close();
		}.bindAsEventListener(this));
		Dialogs.elm('overlay').observe('click', function(){
			if(this.exec(this.opt.close.overlay)) this.close();
		}.bindAsEventListener(this));
		document.observe('keyup', function(e){
			if(this.exec(this.opt.close.esc && (e.which || e.keyCode) == Event.KEY_ESC)) this.close();
		}.bindAsEventListener(this));
		if(this.steps){
			[Dialogs.elm('prev'), Dialogs.elm('next')].invoke('observe', 'click', this.setSteps.bindAsEventListener(this));
			document.observe('keydown', function(e){
				var c = e.which || e.keyCode;
				if(this.exec((c == Event.KEY_LEFT) || (c == Event.KEY_RIGHT))) this.setSteps(e);
			}.bindAsEventListener(this));
		}
	},
	setAuto:function(){
		this.auto = {max:0};
		var t = Dialogs.elm('title'), c = Dialogs.elm('close');
		[t,c].invoke('setStyle', 'float:none');
		$w('top content bottom').each(function(b){
			var e = Dialogs.elm(b);
			if(!e.visible()) this.auto[b] = {width:0,height:0};
			else{
				e.writeAttribute('style', 'display:inline;float:left;overflow:visible;white-space:nowrap');
				this.auto[b] = e.getDimensions();
				e.writeAttribute('style', 'overflow:hidden');
				if(b == 'content') this.auto[b].width += (parseInt(this.opt.padding) || 0) * 2;
				if(this.auto[b].width > this.auto.max) this.auto.max = this.auto[b].width;
			}
		}.bind(this));
		t.setStyle('float:left');
		c.setStyle('float:right');
	},
	setDimensions:function(){
		if(!this.exec(true)) return;
		this.setAuto();
		var a = this.auto,
		    d = Dialogs.view(),
		    t = Dialogs.elm('content'),
			c = Dialogs.elm('container'),
		    o = {
			  m:((parseInt(this.opt.margin) || 0) * 2),
			  p:((parseInt(this.opt.padding) || 0) * 2),
			  t:a.top.height,
			  b:a.bottom.height
			},
		    m = {width:(d.width-o.m), height:(d.height-o.m-o.t-o.b)},
		    h = this.opt.height,
			w = this.opt.width,
		    x = y = false;
		if(Object.isNumber(w)) w += o.p;
		if(w == 'max') w = m.width;
		if(!Object.isNumber(w)) w = a.max;
		if(w < (this.opt.minWidth || 0)) w = this.opt.minWidth || 0;
		if(w > m.width){ w = m.width; x = true }
		t.setStyle('width:'+(w-o.p)+'px;height:auto');
		if(Object.isNumber(h)) h += o.p;
		if(h == 'max') h = m.height;
		if(!Object.isNumber(h)) h = t.getHeight()+o.p;
		if(h < (this.opt.minHeight || 0)) w = this.opt.minHeight || 0;
		if(h > m.height){ h = m.height; y = true; } 
		t.setStyle('height:'+(h-o.p)+'px;padding:'+(o.p/2)+'px');
//              dh: commented out to seperate overflow-x and overflow-y
//		if(this.opt.innerScroll && (x || y)) t.setStyle('overflow:scroll');
		if(this.opt.innerScroll && x) t.setStyle('overflow-x:scroll');
		if(this.opt.innerScroll && y) t.setStyle('overflow-y:scroll');
		var s = {w:w,h:(h+o.t+o.b)};
		c.setStyle('width:'+s.w+'px;height:'+s.h+'px;top:50%;left:50%;margin:-'+parseInt(s.h/2)+'px 0 0 -'+parseInt(s.w/2)+'px');
		if(Dialogs.fix.scroll){
			Dialogs.elm('overlay').setStyle('width:'+d.width+'px;height:'+d.height+'px');
			this.setScroll();
		}
	},
	setScroll:function(){
		if(!this.exec(true)) return;
		var v = Dialogs.view(),
			c = Dialogs.elm('container'),
			d = c.getDimensions(),
			t = v.top + parseInt((v.height - d.height) / 2),
			l = v.left + parseInt((v.width - d.width) / 2);
		c.setStyle('margin:0;top:'+t+'px;left:'+l+'px');
		Dialogs.elm('overlay').setStyle('margin:'+v.top+'px 0 0 '+v.left+'px');
	},
	setLoad:function(){
		var l = Dialogs.elm('loading').show(),
		    t = Dialogs.elm('content'),
		    b = t.down('#'+l.identify());
		if(!Object.isElement(b)) t.insert(l);
	},
	setAjax:function(){
		this.setLoad();
		var o = this.opt.ajax.options || {},
		    c = (o.onComplete && Object.isFunction(o.onComplete) ? o.onComplete : null),
		    a = function(t){
				var tpl = this.opt.ajax.jsonTemplate;
				if(t.responseJSON && Object.isString(tpl)) Dialogs.elm('content').update(tpl.interpolate(t.responseJSON));
				else Dialogs.elm('content').update(t.responseText || '');
				this.setImages();
				this.setDimensions();
				if(Object.isFunction(c)) c(t);
			}.bind(this);
		Object.extend(o, {onComplete:a});
		new Ajax.Request(this.opt.ajax.url, o);
	},
	setIframe:function(){
		this.setLoad();
		var f = new Element('iframe', {src:this.opt.iframe, frameborder:0, id:'dialog-iframe'});
		Dialogs.elm('content').insert(f);
		f.observe('load', function(){
			Dialogs.elm('loading').hide();
			f.setStyle('width:100%;height:100%');
			this.setDimensions();
			if(Object.isFunction(this.opt.afterIframeLoad)) this.opt.afterIframeLoad();
		}.bindAsEventListener(this));
	},
	setSteps:function(ev){
		if(!this.exec(true)) return;
		var m = this.steps.m,
		    s = false,
			n = Dialogs.elm('next'),
			p = Dialogs.elm('prev');
		if((ev.which || ev.keyCode) == Event.KEY_RIGHT || ev.element().hasClassName('next')){
			if(this.steps.i < (m - 1)) s = true;
			if(s) ++this.steps.i;
			if(((this.steps.i + 1) >= m) && n.visible()) n.hide();
			if(((this.steps.i - 1) >= 0) && !p.visible()) p.show();
		}else{
			if(this.steps.i > 0) s = true;
			if(s) --this.steps.i;
			if(((this.steps.i - 1) < 0) && p.visible()) p.hide();
			if(((this.steps.i + 1) <= m) && !n.visible()) n.show();
		}
		if(s) this.setContent();
	},
	setContent:function(){
		var c = this.opt.content,
		    t = Dialogs.elm('content');
		t.update('');
		if(Object.isString(c) || Object.isElement(c)) t.insert(c);
		else if(Object.isArray(c)) c.each(function(b){ t.insert(b); });
		else if(Object.isHash(c)){
			var b = Dialogs.elm('bottom');
			t.update('').insert(this.steps.v[this.steps.i]);
			Dialogs.elm('curr').update(this.steps.k[this.steps.i]);
			if(!b.visible()) b.show().childElements().invoke('show');
			if(this.steps.i <= 0) Dialogs.elm('prev').hide();
			if(this.steps.i >= (this.steps.m - 1)) Dialogs.elm('next').hide();
		}else if(Object.isString(this.opt.ajax.url)) this.setAjax();
		else if(Object.isString(this.opt.iframe)) this.setIframe();
		this.setImages();
		this.setDimensions.bind(this).defer();
	},
	setImages:function(){
		Dialogs.elm('content').select('img').each(function(el){
			el.onload = function(){
				this.setDimensions();
			}.bind(this);
		}.bind(this));
	},
	open:function(){
		if(Dialogs.fix.select)
			$$('select').select(function(el){ return el.visible(); }).invoke('hide').invoke('addClassName', 'dialog-hideselect');
		if(Object.isString(this.opt.title) || this.opt.close.link){
			if(Object.isString(this.opt.title)) Dialogs.elm('title').show().update(this.opt.title);
			if(this.opt.close.link) Dialogs.elm('close').show();
			else Dialogs.elm('close').hide();
			Dialogs.elm('top').show();
		}else Dialogs.elm('top').hide();
		var o = Dialogs.elm('overlay'), c = Dialogs.elm('container'), t = Dialogs.elm('content');
		[o, c, t].invoke('show');
//              dh: commented out background so it can be set via class
//		o.setOpacity(this.opt.opacity || 1).setStyle({background:this.opt.background[0] || '#000'});
		o.setOpacity(this.opt.opacity || 1);
//              dh: commented out background so it can be set via class
//		c.writeAttribute('style', 'left:-99999px;top:-99999px;background:'+(this.opt.background[1] || '#fff'));
		c.writeAttribute('style', 'left:-99999px;top:-99999px;');
		t.writeAttribute('class', this.opt.className || '');
		Dialogs._open = new Date().getTime();
		this._open = Dialogs._open;
		this.setContent();
		if(Object.isFunction(this.opt.afterOpen)) this.opt.afterOpen();
	},
	close:function(){
		Dialogs.close();
		if(Object.isFunction(this.opt.afterClose)) this.opt.afterClose();
	}
};
