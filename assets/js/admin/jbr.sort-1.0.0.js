(function($,a){
/*
 * jQuery serializeObject - v0.2 - 1/20/2010
 * http://benalman.com/projects/jquery-misc-plugins/
 * 
 * Copyright (c) 2010 "Cowboy" Ben Alman
 * Dual licensed under the MIT and GPL licenses.
 * http://benalman.com/about/license/
 */
$.fn.serializeObject=function(){var b={};$.each(this.serializeArray(),function(d,e){var f=e.name,c=e.value;b[f]=b[f]===a?c:$.isArray(b[f])?b[f].concat(c):[b[f],c]});return b};

	//_: array
	//v: pula se !_[i]
	//d: pula se isFunc e d(_[i],i,j)this:_
	$.reIndex = function(_,v,d){
		if(!$.isArray(_))return _;
		if($.isFunction(v))d = v,v = 0;
		var isf = $.isFunction(d),i=0,j=0,t;
		for(;i<_.length; i++){
			t = $.type(_[i]);
			if(t=='null'||t=='undefined'||(v&&!_[i]))continue;
			if(isf&&d.call(_,_[i],i,j))continue;
			_[j++] = _[i];
		}
		_.length = j;
		return _;
	};
	//_: array
	//k: orders
	//ro: return []o
	$.sort = function(_,k,ro){
		if($.type(_)=='string')k = _,ro = 1;
		else if(!$.isArray(_))return _;
		var o = [],i=0,v,t = $.type(k),
		add = function(c,d){
			if($.type(c)=='string'&&$.type(d)=='undefined'){
				c = $.trim(c).split(' ');
				d = c[1];
				c = c[0];
			}
			if($.type(c)=='array')d = c[1],c = c[0];
			d = d===false||(d==0&&$.isNumeric(d))||$.trim(d).toLowerCase()=='desc'?false:d==2?2:d==3?3:true;
			if($.type(c)=='string'&&$.trim(c))o.push([$.trim(c),d]);
		},
		ver = function(a,b,d){
			if(d===2)return Math.round(Math.random())-0.5;// -.5 ou .5
			if(d===3)return Math.round(Math.random()*(2))-1;// -1 ou 0 ou 1
			if(typeof a=='string')a = $.trim(a).toLowerCase();
			if(typeof b=='string')b = $.trim(b).toLowerCase();
			if(a<b)return d?-1:1;
			else if(a>b)return d?1:-1;
			return 0;
		};
		if(t=='null'||t=='undefined')k = 1,t = 'number';

		if(t=='string'||t=='array'){
			if(t=='string')k = k.split(',');
			for(;v=k[i++];)add(v);
		}else if(t=='object')for(i in k)add(k,v[i]);
		else if(t=='function')return _.sort(k);
		else if(t=='number'||t=='boolean')return _.sort(function(a,b){
			return ver(a,b,k);
		});
		else return _;

		if(ro)return o;
		if(!o.length)return _;

		return _.sort(function(a,b){
			var i=0,v,d;
			for(;v=o[i++];)if(d=ver(a[v[0]],b[v[0]],v[1]))return d;
			return 0;
		});
	}
})(jQuery);
