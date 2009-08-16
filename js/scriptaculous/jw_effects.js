/*
	FYI:
		"restoreAfterFinish" is only used by Scale and all its subclasses and puts the element 
			back where it was the size that it was.

	Bugs:
		SlideLeftIn still doesn't work on IE ???

		'delete' does not work on IE

		Cannot set styles of table items in Builder.node due to IE bug

		stray commas after last item in lists causes IE to fail


		Effect.toggle on these effects doesn't seem to work quite right
			(  Effect.toggle('demo-effect-curtainopen','slideleft')  )

		Not allowing Effect.Curtain* to finish before clicking again causes a problem.

		Not allowing MOST effects to finish before clicking again causes a problem.
*/


/* This declaration doesn't show up correctly when using Firebug */
/* 
	Also, these toggles don't seem to work right either
	OK:  slideup, slidedown, slideright
	NOT: slideleft, curtain
*/
Effect.PAIRS = Object.extend(
	Effect.PAIRS, { 
		'slidedown':  ['SlideDownIn',  'SlideDownOut'],
		'slideup':    ['SlideUpIn',    'SlideUpOut'],
		'slideleft':  ['SlideLeftIn',  'SlideLeftOut'],
		'slideright': ['SlideRightIn', 'SlideRightOut'],
		'curtain':    ['CurtainClose', 'CurtainOpen']
	}
);


Object.extend(
	Effect, {
		_elementIsNotAListError: {
			name: 'ElementIsNotAListError',
			message: 'The specified DOM element is not a list exist, but is required to be for this effect to operate'
		}
  }
);


Effect.PulseList = Class.create();
Object.extend(Object.extend(Effect.PulseList.prototype, Effect.Base.prototype), {
	initialize: function(element) {
		this.element = $(element);
		if(!this.element) throw(Effect._elementDoesNotExistError);
//		if( (this.element.tagName != "UL") && (this.element.tagName != "OL") )
		if( ! ['UL','OL'].include(this.element.tagName) )
			throw(Effect._elementIsNotAListError);
		if ( ! this.element.effectOn ) {
			this.element.effectOn = true;
			var options = Object.extend({
				_pulse: 1,
				direction: "down",		// up or down
				pulses: 1,
				continuous: false,
				bounce: false,
				duration: 2,
				min_opacity: 0.1
			}, arguments[1] || {});
			this.start(options);
		}
	},
	setup: function() {
		var num_items = this.element.immediateDescendants().size();
		var i = 1;
		var self = this;
		this.element.immediateDescendants().each( function(myitem){
			var mydelay = (self.options.direction == "down" ) 
				? (i++ - 1)/num_items
				: (num_items - i++)/num_items;
			var reverser   = function(pos){ return Effect.Transitions.sinoidal(1-Effect.Transitions.pulse(pos, 1)) }
			new Effect.Opacity(myitem, 
				Object.extend(Object.extend({
					delay: mydelay, 
					duration: self.options.duration, 
					from: self.options.min_opacity,
					afterFinishInternal: function(effect) {
						if ( ! ( self.options.direction == 'down' ? myitem.next() : myitem.previous() ) ) {
							if ( ( self.options.continuous ) || ( self.options._pulse++ < self.options.pulses ) ){
								if ( self.options.bounce) 
									self.options.direction = ( self.options.direction == 'up' ) ? 'down' : 'up';
								new Effect.PulseList(effect.element.parentNode, self.options || {} );
							}
						}
					}
				}, {}), {transition: reverser})
			);
		});
	},
	finish: function() {
//		delete(this.element.effectOn);
		this.element.effectOn = false;
	}
});


Effect.Gradient = Class.create();
Object.extend(Object.extend(Effect.Gradient.prototype, Effect.Base.prototype), {
	initialize: function(element) {
		this.element = $(element);
		if(!this.element) throw(Effect._elementDoesNotExistError);
		var options = Object.extend({
			duration: 5,
			rows: 10,
			cols: 10,
			type: 'diagonal',		/*	vertical, horizontal, diagonal */
			colors: [ 'black', 'white', 'white', 'black' ]
		}, arguments[1] || {});
		if (options.type == 'horizontal') options.rows = 1;
		else if (options.type == 'vertical') options.cols = 1;

		dims = this.element.getDimensions();
		cellwidth  = dims.width  / options.cols;
		cellheight = dims.height / options.rows;
		this.cellids = [];
		var self = this;
		this.table = Builder.node('table', {
			border: 0, cellpadding: 0, cellspacing: 0,
			style:"margin: 0px; padding: 0px;"
		});
		tbody = Builder.node('tbody');
		$(tbody).setStyle({ margin: 0, padding: 0 });
		$R(1,options.rows).each( function(row){
			tr = Builder.node('tr');
			$(tr).setStyle({ margin: 0, padding: 0 });
			if (options.type == 'vertical') {
				cellcolor = Color.shade( 
					Color.string2hex(options.colors[0]), 
					Color.string2hex(options.colors[1]), 
					(row-1)/(options.rows-1) 
				);
			}
			$R(1,options.cols).each( function(col){
				cellid = "grcell-"+row+"-"+col;
				if (options.type == 'diagonal') {
					cellcolor = Color.shade( 
						Color.shade( 
							Color.string2hex(options.colors[0]), 
							Color.string2hex(options.colors[1]), 
							(col-1)/(options.cols-1) 
						), 
						Color.shade( 
							Color.string2hex(options.colors[2]), 
							Color.string2hex(options.colors[3]), 
							(col-1)/(options.cols-1) 
						),
						(row-1)/(options.rows-1) 
					);
				} else if (options.type == 'horizontal') {
					cellcolor = Color.shade( 
						Color.string2hex(options.colors[0]), 
						Color.string2hex(options.colors[1]), 
						(col-1)/(options.cols-1) 
					);
				}
				td = Builder.node('td',{
					id: cellid
				}, "" );
				$(td).setStyle({ margin: '0px', padding: '0px',
					height: cellheight+'px', 
					width:  cellwidth+'px', 
					backgroundColor: cellcolor
				});
				tr.appendChild(td);
				self.cellids.push(cellid);
			});
			tbody.appendChild(tr);
		});
		this.table.appendChild(tbody);

		this.start(options);
	},
	setup: function(){
		Position.absolutize(this.element);
		this.element.parentNode.appendChild(this.table);
		Position.absolutize(this.table);
	},
	finish: function(){
		new Effect.Fade( this.table , {
			afterFinish: function(effect) {
				effect.element.parentNode.removeChild(effect.element);
			}
		});
	}
});

Effect.ORIGGradient = Class.create();
Object.extend(Object.extend(Effect.ORIGGradient.prototype, Effect.Base.prototype), {
	initialize: function(element) {
		this.element = $(element);
		if(!this.element) throw(Effect._elementDoesNotExistError);
		var options = Object.extend({
			duration: 5,
			rows: 10,
			cols: 10,
			type: 'diagonal',		/*	vertical, horizontal, diagonal */
			colors: [ 'black', 'white', 'white', 'black' ]
		}, arguments[1] || {});
		if (options.type == 'horizontal') options.rows = 1;
		else if (options.type == 'vertical') options.cols = 1;

		dims = this.element.getDimensions();
		cellwidth  = dims.width  / options.cols;
		cellheight = dims.height / options.rows;
		this.cellids = [];
		var self = this;
		this.table = Builder.node('table', {
			border: 0, cellpadding: 0, cellspacing: 0,
			style:"margin: 0px; padding: 0px;"
		});
		tbody = Builder.node('tbody', { style:"margin: 0px; padding: 0px;" });
		$R(1,options.rows).each( function(row){
			tr = Builder.node('tr', { style:"margin: 0px; padding: 0px;" });
			if (options.type == 'vertical') {
				cellcolor = Color.shade( 
					Color.string2hex(options.colors[0]), 
					Color.string2hex(options.colors[1]), 
					(row-1)/(options.rows-1) 
				);
			}
			$R(1,options.cols).each( function(col){
				cellid = "grcell-"+row+"-"+col;
				if (options.type == 'diagonal') {
					cellcolor = Color.shade( 
						Color.shade( 
							Color.string2hex(options.colors[0]), 
							Color.string2hex(options.colors[1]), 
							(col-1)/(options.cols-1) 
						), 
						Color.shade( 
							Color.string2hex(options.colors[2]), 
							Color.string2hex(options.colors[3]), 
							(col-1)/(options.cols-1) 
						),
						(row-1)/(options.rows-1) 
					);
				} else if (options.type == 'horizontal') {
					cellcolor = Color.shade( 
						Color.string2hex(options.colors[0]), 
						Color.string2hex(options.colors[1]), 
						(col-1)/(options.cols-1) 
					);
				}
				td = Builder.node('td',{
					id: cellid,
					style:"margin: 0px; padding: 0px; "
						+"height: "+cellheight+"px; "
						+"width: "+cellwidth+"px; "
						+"background-color: "+cellcolor
				}, "" );
				tr.appendChild(td);
				self.cellids.push(cellid);
			});
			tbody.appendChild(tr);
		});
		this.table.appendChild(tbody);

		Position.absolutize(this.element);
		this.element.parentNode.appendChild(this.table);
		Position.absolutize(this.table);
		this.start(options);
	},
	finish: function(){
		new Effect.Fade( this.table , {
			afterFinish: function(effect) {
				effect.element.parentNode.removeChild(effect.element);
			}
		});
	}
});


Effect.Pixelate = Class.create();
Object.extend(Object.extend(Effect.Pixelate.prototype, Effect.Base.prototype), {
	initialize: function(element) {
		this.element = $(element);
		if(!this.element) throw(Effect._elementDoesNotExistError);
		var options = Object.extend({
			duration: 5,
			rows: 30,
			cols: 30,
			startcolor: 'transparent',
			endcolor: 'white'
		}, arguments[1] || {});
		options.cells = options.rows * options.cols;

		dims = this.element.getDimensions();
		cellwidth  = dims.width  / options.cols;
		cellheight = dims.height / options.rows;
		this.cellids = [];
		this.table = Builder.node('table', {
			border: 0, cellpadding: 0, cellspacing: 0,
			style:"margin: 0px; padding: 0px;"
		});
		/*	Cannot set styles of table items in Builder.node due to IE bug */
		var self = this;
		tbody = Builder.node('tbody');
		$(tbody).setStyle({ margin: 0, padding: 0 });
		$R(1,options.rows).each( function(row){
			tr = Builder.node('tr');
			$(tr).setStyle({ margin: '0px', padding: '0px' });
			$R(1,options.cols).each( function(col){
				cellid = "pxcell-"+row+"-"+col;
				td = Builder.node('td',{
					id: cellid
				}, '');
				$(td).setStyle({ margin: '0px', padding: '0px',
					height: cellheight+'px', 
					width:  cellwidth+'px', 
					backgroundColor: options.startcolor
				});
				tr.appendChild(td);
				self.cellids.push(cellid);
			});
			tbody.appendChild(tr);
		});
		this.cellids.sort( function(a,b){return (0.5 - Math.random());} );
		this.table.appendChild(tbody);
		this.start(options);
	},
	setup: function() {
		Position.absolutize(this.element);
		this.element.parentNode.appendChild(this.table);
		Position.absolutize(this.table);
	},
	update: function(position) {
		while ( this.cellids.size() && (this.cellids.size()/this.options.cells) > (1-position) ) {
			$(this.cellids.pop()).setStyle({ backgroundColor: this.options.endcolor });
		}
	},
	finish: function(){
		new Effect.Fade( this.table , {
			afterFinish: function(effect) {
				effect.element.parentNode.removeChild(effect.element);
			}
		});
	}
});



Effect.Duplicate = Class.create();
Object.extend(Object.extend(Effect.Duplicate.prototype, Effect.Base.prototype), {
	initialize: function(element) {
		this.element = $(element);
		if(!this.element) throw(Effect._elementDoesNotExistError);

		this.element.makePositioned();
		this.elecopy = this.element.cloneNode(true);
		this.elecopy.setStyle({ color: 'red', backgroundColor: 'red', backgroundImage: '' });
		this.elecopy.id = element.id + '-copy';
		this.element.parentNode.appendChild(this.elecopy);
		Position.relativize(this.element);
		Position.relativize(this.elecopy);
		Position.absolutize(this.element);
		Position.absolutize(this.elecopy);

		var options = Object.extend({
		}, arguments[1] || {});
		this.start(options);
	},
	asetup: function() {
		return new Effect.Parallel ( [
			new Effect.SlideRightIn(this.element, { sync:true }),
			new Effect.SlideLeftIn( this.elecopy, { sync:true }) 
			], Object.extend({ 
				duration: 2
			}, arguments[1] || {})
		);
	},
	update: function(position) {
	},
	finish: function() {
		this.elecopy.undoClipping().undoPositioned().remove();
	}
});

Effect.Flicker = Class.create();
Object.extend(Object.extend(Effect.Flicker.prototype, Effect.Base.prototype), {
	initialize: function(element) {
		this.element = $(element);
		if(!this.element) throw(Effect._elementDoesNotExistError);
		if ( ! this.element.effectOn ) {
			this.element.effectOn = true;
			var options = Object.extend({
				threshold: 0.5,
				endvisibility: "visible"
			}, arguments[1] || {});
			this.start(options);
		}
	},
	update: function(position) {
		var visibility = ( Math.random() < this.options.threshold ) ? "hidden" : "visible";
		this.element.setStyle({
			visibility: visibility
		});
	},
	finish: function() {
		this.element.setStyle({
			visibility: this.options.endvisibility
		});
//		delete(this.element.effectOn);
		this.element.effectOn = false;
	}
});


Effect.CurtainClose = function(element) {
/* 
	CurtainClose need to have the content of the element wrapped in a container element with fixed width AND height!
*/
	element = $(element).cleanWhitespace();
	var elementDimensions = element.getDimensions();

	element.makeClipping().makePositioned();
	element.parentNode.makeClipping();	//	stops SlideLeftIn flicker
	elecopy = $(element.cloneNode(true));
	elecopy.setStyle({ top: '0px', left: '0px' });
	elecopy.id = element.id + '-copy';
	element.parentNode.appendChild(elecopy);
	elecopy.makeClipping().makePositioned();
	Position.absolutize(element);

	return new Effect.Parallel ( [
		new Effect.SlideRightIn(element, { sync:true }),
		new Effect.SlideLeftIn( elecopy, { sync:true }) 
		], Object.extend({ 
			duration: 2,
			afterFinishInternal: function(effect){
				elecopy.undoClipping().undoPositioned().remove();
/*	why does the above work and the below does not? */
//				effect.effects[1].element.undoClipping().undoPositioned().remove();
				effect.effects[0].element.parentNode.undoClipping();
			}
		}, arguments[1] || {})
	);
}

Effect.CurtainOpen = function(element) {
/* 
	CurtainOpen need to have the content of the element wrapped in a container element with fixed width AND height!
*/
	element = $(element).cleanWhitespace();

	element.makeClipping().makePositioned();
	element.parentNode.makeClipping();
	elecopy = element.cloneNode(true);
	elecopy.setStyle({ top: '0px' });
	elecopy.id = element.id + '-copy';
	element.parentNode.appendChild(elecopy);
	Position.absolutize(element);
	Position.absolutize(elecopy);

	var elementDimensions = element.getDimensions();
	return new Effect.Parallel ( [
		new Effect.SlideRightOut(element, { sync:true }),
		new Effect.SlideLeftOut( elecopy, { sync:true })
		], Object.extend({ 
			duration: 2,
			beforeSetup: function(effect){
				effect.effects[1].element.makeClipping().makePositioned().show();
			},
			afterFinishInternal: function(effect){
				element.undoClipping().undoPositioned();
/*	why does the above work and the below does not? */
//				effect.effects[0].element.undoClipping().undoPositioned();	
				effect.effects[1].element.parentNode.undoClipping();
				effect.effects[1].element.undoClipping().undoPositioned().remove();
			}
		}, arguments[1] || {})
	);
}


Effect.SlideLeftIn = function(element) {
/* 
	SlideLeftIn need to have the content of the element wrapped in a container element with fixed width!
*/
	element = $(element).cleanWhitespace();
	if ( ! element.effectOn ) {
		element.effectOn = true;
		var elementDimensions = element.getDimensions();
		return new Effect.Parallel ( [
			new Effect.Move(element, 
				Object.extend({ 
					x: -(elementDimensions.width), 
					sync: true, 
					mode: 'relative', 
					beforeStartInternal: function(effect) {
						if(window.opera) effect.element.setStyle({left: ''});
						effect.element.setStyle({left: elementDimensions.width + 'px' });
						effect.element.show();
					}
				}, arguments[1] || {})
			),
			new Effect.Scale(element, 100,
				Object.extend({ scaleContent: false, 
					/* why does the use of sync: true make this flicker? */
					scaleY: false,
					scaleFrom: window.opera ? 0 : 1
				}, arguments[1] || {})
			)
			], Object.extend({
				beforeSetup: function(effect){
					effect.effects[0].element.parentNode.makeClipping();
					effect.effects[0].element.makeClipping();
				},
				afterFinishInternal: function(effect){
					effect.effects[0].element.parentNode.undoClipping();
					effect.effects[0].element.undoClipping();
				},
				afterFinish: function(effect){
//					delete(effect.effects[0].element.effectOn);
					effect.effects[0].element.effectOn = false;
				}
			}, arguments[1] || {})
		);
	}
}


Effect.SlideRightOut = function(element) {
/* 
	SlideRightOut need to have the content of the element wrapped in a container element with fixed width!
*/
	element = $(element).cleanWhitespace();
	var elementDimensions = element.getDimensions();
	return new Effect.Parallel ( [
		new Effect.Move(element, { x: element.getWidth(), sync: true, mode: 'relative' }),
		new Effect.Scale(element, window.opera ? 0 : 1, {	
			sync: true, 
			scaleContent: false, 
			scaleY: false,
			scaleFrom: 100,
			restoreAfterFinish: true
		})
		], Object.extend({ 
			beforeSetup: function(effect){
				effect.effects[0].element.makeClipping();
			},
			afterFinishInternal: function(effect){
				effect.effects[0].element.undoClipping().hide();
			}
		}, arguments[1] || {})
	);
}



/* from SlideUp */
Effect.SlideLeftOut = function(element) {
/*
	SlideLeftOut needs to have the content of the element wrapped in a container element with fixed width
	otherwise any text or images begin to wrap in stange ways!
*/
	element = $(element).cleanWhitespace();
	return new Effect.Scale(element, window.opera ? 0 : 1,
		Object.extend({ 
			scaleContent: false, 
			scaleY: false, 
			scaleMode: 'box',
			scaleFrom: 100,
			restoreAfterFinish: true,
			beforeStartInternal: function(effect) {
				effect.element.makePositioned();
				effect.element.down().makePositioned();
				if(window.opera) effect.element.setStyle({left: ''});
				effect.element.makeClipping().show();
			},  
			afterUpdateInternal: function(effect) {
				effect.element.down().setStyle(
					{right: (effect.dims[1] - effect.element.clientWidth) + 'px' }
				);
			},
			afterFinishInternal: function(effect) {
				effect.element.hide().undoClipping().undoPositioned();
				effect.element.down().undoPositioned();
			}
		}, arguments[1] || {})
	);
}


/* from SlideDown */
Effect.SlideRightIn = function(element) {
/*
	SlideRightIn needs to have the content of the element wrapped in a container element with fixed width!
*/
	element = $(element).cleanWhitespace();
	var elementDimensions = element.getDimensions();
	return new Effect.Scale(element, 100, 
		Object.extend({ 
			scaleContent: false, 
			scaleY: false, 
			scaleFrom: window.opera ? 0 : 1,
			scaleMode: {originalHeight: elementDimensions.height, originalWidth: elementDimensions.width},
			restoreAfterFinish: true,
			afterSetup: function(effect) {
				effect.element.makePositioned();
				effect.element.down().makePositioned();
				if(window.opera) effect.element.setStyle({left: ''});
				effect.element.makeClipping().setStyle({width: '0px'}).show(); 
			},
			afterUpdateInternal: function(effect) {
				effect.element.down().setStyle({right: (effect.dims[1] - effect.element.clientWidth) + 'px' }); 
			},
			afterFinishInternal: function(effect) {
				effect.element.undoClipping().undoPositioned();
				effect.element.down().undoPositioned();
			}
		}, arguments[1] || {})
	);
}



Effect.SlideUpIn = function(element) {
/* 
	SlideUpIn need to have the content of the element wrapped in a container element with fixed height!
*/
	element = $(element).cleanWhitespace();
	var elementDimensions = element.getDimensions();
	return new Effect.Parallel ( [
		new Effect.Move(element, { y: -(element.getHeight()), sync: true, mode: 'relative' }),
		new Effect.Scale(element, 100, 
			Object.extend({
				sync: true,
				scaleContent: false,
				scaleX: false,
				scaleFrom: 0,
				scaleMode: {originalHeight: elementDimensions.height, originalWidth: elementDimensions.width},
				beforeSetup: function(effect) {
					effect.element.hide();
				},
				afterSetup: function(effect) {
					effect.element.makeClipping().setStyle({height: '0px'}).show();
				},
				afterFinishInternal: function(effect) {
					effect.element.undoClipping();
				}
			}, arguments[1] || {})
		)
	], Object.extend({
		afterSetup: function(effect) {
			effect.effects[0].element.setStyle({top: elementDimensions.height + 'px' });
		}
	}, arguments[1] || {}));
}


Effect.SlideDownOut = function(element) {
/* 
	SlideDown need to have the content of the element wrapped in a container element with fixed height!
*/
	element = $(element).cleanWhitespace();
	var elementDimensions = element.getDimensions();
	return new Effect.Parallel ( [
		new Effect.Move(element, { y: element.getHeight(), sync: true, mode: 'relative' }),
		new Effect.Scale(element, 0,
			Object.extend({ 
				sync: true,
				scaleContent: false,
				scaleX: false,
				restoreAfterFinish: true,
				beforeSetup: function(effect){
					effect.element.makeClipping();
				},
				afterFinishInternal: function(effect) {
					effect.element.hide().undoClipping();
				}
			}, arguments[1] || {})
		)
	], Object.extend({
	}, arguments[1] || {}));
}



/* this is the original SlideDown */
Effect.SlideDownIn = function(element) {
	element = $(element).cleanWhitespace();
	// SlideDown need to have the content of the element wrapped in a container element with fixed height!
	var oldInnerBottom = element.down().getStyle('bottom');
	var elementDimensions = element.getDimensions();
	return new Effect.Scale(element, 100, 
		Object.extend({ 
			scaleContent: false, 
			scaleX: false, 
			scaleFrom: window.opera ? 0 : 1,
			scaleMode: {originalHeight: elementDimensions.height, originalWidth: elementDimensions.width},
			restoreAfterFinish: true,
			afterSetup: function(effect) {
				effect.element.makePositioned();
				effect.element.down().makePositioned();
				if(window.opera) effect.element.setStyle({top: ''});
				effect.element.makeClipping().setStyle({height: '0px'}).show(); 
			},
			afterUpdateInternal: function(effect) {
				effect.element.down().setStyle({bottom:
				(effect.dims[0] - effect.element.clientHeight) + 'px' }); 
			},
			afterFinishInternal: function(effect) {
				effect.element.undoClipping().undoPositioned();
				effect.element.down().undoPositioned().setStyle({bottom: oldInnerBottom}); 
			}
		}, arguments[1] || {})
	);
}

/* this is the original SlideUp */
Effect.SlideUpOut = function(element) {
	element = $(element).cleanWhitespace();
	var oldInnerBottom = element.down().getStyle('bottom');
	return new Effect.Scale(element, window.opera ? 0 : 1,
		Object.extend({ 
			scaleContent: false, 
			scaleX: false, 
			scaleMode: 'box',
			scaleFrom: 100,
			restoreAfterFinish: true,
			beforeStartInternal: function(effect) {
				effect.element.makePositioned();
				effect.element.down().makePositioned();
				if(window.opera) effect.element.setStyle({top: ''});
				effect.element.makeClipping().show();
			},  
			afterUpdateInternal: function(effect) {
				effect.element.down().setStyle({bottom:
				(effect.dims[0] - effect.element.clientHeight) + 'px' });
			},
			afterFinishInternal: function(effect) {
				effect.element.hide().undoClipping().undoPositioned().setStyle({bottom: oldInnerBottom});
				effect.element.down().undoPositioned();
			}
		}, arguments[1] || {})
	);
}


