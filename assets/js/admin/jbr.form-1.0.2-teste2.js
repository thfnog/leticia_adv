(function($) {
	var _logs = [],
		l = function(_, a) {
			if (a != null) _.bSub && _.bSub[(_._l = a ? true : false) ? 'addClass' : 'removeClass'](_._lcb);
			return _._l;
		},
		up = function(_) {
			var F = _.F,
				i;
			if (l(_)) return false;
			l(_, true);
			i = $.type(_.file) == 'string' ? F.find(_.file) : $(_.file);
			if (_.box) $.each(_.box, function(k, v) {
				v.e.find('.msg').addClass('no').removeClass('ok err');
			});
			i.upfile(function(e, d) {
				if ((_.filea && _.filea(_, e, d)) === false) return;
				$.post('ajax/' + (_.u || '') + (_.a || '') + '.json', F.serialize(), function(x) {
					if ((_.success && _.success(_, x, e, d)) === false) return;
					x.bok = 0;
					x.berr = 0;
					if (x.box && _.box) $.each(x.box, function(k, v, b) {
						if (b = _.box[k]) {
							if (v.ok) x.bok += v.ok;
							if (v.err) x.berr += v.err;
							$.each(v, function(i, w) {
								if (!$.isNumeric(i)) return;
								var e = box.el(b, i);
								if (w.m) e.find('.msg').addClass(w.ok ? 'ok' : w.noup ? '' : 'err').removeClass('no').html(w.m);
								if (w.id != null) e.find('.c-id').val(w.rmv ? 0 : w.id);
								if (w.rmv) box.rmv(b, i);
							});
						}
					});
					if (x.id != null) $(_.f.id).val(x.id);
					if (x.ok) {
						if ((_.ok && _.ok(_, x, e, d)) === false) return;
					} else if (x.noup) {
						if ((_.noup && _.noup(_, x, e, d)) === false) return;
					} else if ((_.no && _.no(_, x, e, d)) === false) return;
					if (!_.id && (x.ok || x.noup) && !x.berr) _reset(_, x, e, d);
					if (x.ok && _.id && x.i && _.i) $.each(x.i, function(k, v) {
						img(_, _.i[k] = v, k);
						text(_, v, k);
					});
					if (x.noi && _.i) $.each(x.noi, function(k, v) {
						if (v) img(_, _.i[k], k), text(_, _.i[k], k);
					});
					//if(x.m)alert(x.m);
					if(x.m){
						$('#sys-notification').show();
						var answer = x.ok==1?'success':'danger';
						var icon = x.ok==1?'check':'question';
						$('#notification').html('<div class="alert alert-'+answer+'"><i class="fa fa-'+icon+'-circle"></i> '+x.m+'-'+x.l+'<button type="button" class="close" data-dismiss="alert">×</button></div>').show();
						//$("html, body").animate({scrollTop:100},600);
						setTimeout(function(){$('#notification').hide();},6000);
						if(x.resetCaptcha)grecaptcha.reset();
					}
					if(x.f){
						$("#"+x.f).focus().addClass('haserror').css('border-color','#f00');
						return hasError(x.f);
					}
					if ($.type(x.l) == 'string') location = x.l;
					if (x.loc){
						location.href = x.loc;
						alert('teste');
					}
				}, 'json').complete(function(x) {
					var i = _logs.length,
						L = x.responseText,
						c = window.console && console.log && console;
					_.debug && alert(L);
					if (_.log) {
						try {
							L = $.parseJSON(L);
						} catch (e) {};
						_logs[i] = L;
						c && c.log(i);
						c && c.log(L);
					}
					if ((_.complete && _.complete(_, x, e, d)) === false) return;
					l(_, false);
				});
			}, function(v, r, i) {
				if ((_.fileb && _.fileb(_, v, r)) === false) return;
				img(_, r.tf, i = $(v.e).attr('i'));
				text(_, r.n, i);
			}, _.upfile);
			return false;
		},
		_reset = function(_, x, e, d) {
			if ((_.reset && _.reset(_, x, e, d)) === false) return;
			_.f.reset();
			_.F.find('textarea').each(function(i, d) {
				d = $(d).data();
				d.edt && d.edt.set();
			});
			if (_.box) $.each(_.box, function(k, v) {
				v.e.find('>div').hide(300, function() {
					$(this).remove();
				});
			});
			if (_.i) $.each(_.i, function(k) {
				img(_, 0, k);
				text(_, 0, k);
			});
			if (_.y) $.each(_.y, function(k) {
				ytb(_, 0, k);
			});
		},
		img = function(_, i, e) {
			$('#img-view' + (e ? '-' + e : '')).css('display', i ? '' : 'none').find('img').attr('src', i ? i : '');
		},
		text = function(_, t, e) {
			$('#text-view' + (e ? '-' + e : '')).css('display', t ? '' : 'none').find('.text').text(t);
		},
		ytb = function(_, y, e) {
			$('#ytb-view' + (e ? '-' + e : '')).css('display', y ? '' : 'none').find('iframe').attr('src', y ? 'http://www.youtube.com/embed/' + y + '?rel=0' : '');
		},
		_add = function(_, e, c) {
			e = $(e).hide();
			e[e.attr('tipo') || 'prepend']($(c).addClass(e.attr('cls')));
			e.removeAttr('cls tipo');
		},
		_img = function(_, e) {
			_add(_, $('#img-view' + (e ? '-' + e : '')), '<label><div class="img"><img/></div></label>');
		},
		_text = function(_, e) {
			_add(_, $('#text-view' + (e ? '-' + e : '')), '<label><span class="text"></span></label>');
		},
		_ytb = function(_, e) {
			_add(_, $('#ytb-view' + (e ? '-' + e : '')), '<label><span class="label"></span><iframe src="javascript:;" width="560" height="315" frameborder="0" allowfullscreen="allowfullscreen" allowtransparency="allowtransparency"></iframe></label>');
		},
		cgY = function(_, e, k, re, v) {
			e = $(e);
			k = e.attr('i') || e.attr('name');
			re = /^.*(?:(?:youtu.be\/)|(?:v\/)|(?:\/u\/\w\/)|(?:embed\/)|(?:watch\?))\??v?=?([^#&?]*).*/;
			v = e.val();
			if (re.test(v)) e.val(v = e.val().replace(re, '$1'));
			if (v.length != 11) e.val(v = '');
			if (v != _.y[k]) ytb(_, _.y[k] = v, k);
		},
		box = {
			i: 0,
			el: function(_, i) {
				return $('#' + _.p + '-' + i);
			},
			rmv: function(_, i) {
				var e = box.el(_, i);
				e.hide(300, function() {
					if (e.find('.c-id[value=0]').length) e.remove();
				}).find('.c-rmv').val(1);
			},
			add: function(_, v) {
				var i = box.i++,
					e;
				v = $.extend({
					id: 0,
					rmv: 0
				}, _.v || {}, v || {});
				e = $(['<div class="form form-in" id="' + _.p + '-' + i + '">', '<input type="hidden" class="c-id"/>', '<input type="hidden" class="c-rmv"/>', '<span class="ico idel close" style="opacity:1"></span>', '<label class="top msg no"></label>', '</div>'].join(''));
				e.hide().append(_.html || '').find('.ico.close:first').attr('title', _.r || '').click(function() {
					box.rmv(_, i);
				});
				_.init && _.init(_, e, v);
				$.each(v, function(j, w) {
					var d = e.find('.c-' + j).attr('name', 'box[' + _.k + '][' + j + '][' + i + ']'),
						t = (d.attr('type') || '').toLowerCase();
					if (t === 'checkbox') d.attr('checked', !!w);
					else if (t === 'radio') d.each(function(k, x) {
						x = $(x);
						x.attr('checked', w == x.val());
					});
					else if (t !== 'file') d.val(w == null ? '' : w);
				});
				_.e.append(e);
				_.load && _.load(_, e, v);
				e.show(300);
			}
		},
		addBox = function(_, k, v) {
			if ($.type(v) == 'string') k = v;
			k = k || '';
			v = $.extend(true, {
				k: k
			}, _box, $.type(v) == 'object' && v || {});
			v._ = _;
			if (k) _.box[k] = v;
			var t = $('<h3 style="display:none"></h3>').text(v.t || ''),
				a = $('<label><span class="ico iadd" style="float:left"></span><h3 style="float:left;margin:4px">'+v.t+'</h3></label>').attr('title', v.a || '').click(function() {
					box.add(v);
				});
			if (k && !v.p) v.p = 'box-' + k;
			v.e = $('#' + v.p).after(a);
			if (v.t) v.e.before(t);
			v.html = $.isArray(v.html) && v.html.join('') || v.html || '';
			$.each('init load'.split(' '), function(i, w) {
				v[w] = v[w] === false ? false : $.isFunction(v[w]) && v[w] || null;
			});
			if (v.rs) $.each(v.rs, function() {
				box.add(v, this);
			});
			return v;
		},
		init = function(_) {
			var F = $(_.F || fn.F),
				f = F[0],
				t, id = F.addClass(_.style ? 'form' : '').find('input[type=hidden][name=id]');
			if (_.submit) F.submit(function() {
				return up(_);
			});
			_.F = F;
			_.f = f;
			if (!id.length) F.prepend('<input type="hidden" name="id" value="' + _.id + '"/>');
			if (_.bSub == null) _.bSub = fn.bSub;
			if (_.file == null) _.file = fn.file;
			if ($.type(_.bSub) == 'string') _.bSub = F.find(_.bSub)[0];
			_.bSub = $(_.bSub).addClass(_.style ? 'block' : '').attr('title', t = $.isArray(_.sub) && _.sub[_.id ? 1 : 0] || _.sub || '');
			if (_.bSubFind) _.bSub.find(_.bSubFind).html(t);
			else _.bSub.val(t);
			if (_.back) {
				_.bBack = $('<a class="btn btn-danger">Voltar</a>').attr('href', _.back);
				_.bSub.addClass('left mr').after(_.bBack);
			}
			if (_.i) $.each(_.i, function(k, v) {
				_img(_, k);
				_text(_, k);
				img(_, v, k);
				text(_, v, k);
			});
			if (_.y) $.each(_.y, function(k, v) {
				_ytb(_, k);
				ytb(_, v, k);
				$(f[k]).change(function() {
					cgY(_, this);
				}).change();
			});
			if (_.box) $.each(_.box, function(k, v) {
				addBox(_, k, v);
			});
			_.load && _.load(_, F, f);
		},
		fn = {
			_l: false,
			_lcb: 'face',
			u: 'u/',
			a: '',
			F: '#id-form',
			f: null,
			style: true,
			submit: true,
			upfile: null,
			file: '[type=file]',
			sub: ['Cadastrar', 'Salvar'],
			bSub: '[type=submit]',
			bSubFind: '',
			bBack: null,
			back: '',
			_load: 0,
			id: 0,
			i: {},
			y: {},
			debug: false,
			log: false,

			box: {},
			l: function(a) {
				return l(this, a);
			},
			up: function() {
				return up(this);
			},
			_reset: function(x, e, d) {
				_reset(this, x, e, d);
			},
			img: function(i, e) {
				img(this, i, e);
			},
			text: function(t, e) {
				text(this, t, e);
			},
			ytb: function(y, e) {
				ytb(this, y, e);
			},
			_add: function(e, c) {
				_add(this, e, c);
			},
			_img: function(e) {
				_img(this, e);
			},
			_text: function(e) {
				_text(this, e);
			},
			_ytb: function(e) {
				_ytb(this, e);
			},
			cgY: function(e) {
				cgY(this, e);
			},
			init: function() {
				init();
			},
			addBox: function(k, v) {
				addBox(this, k, v);
			}
		},
		_box = {
			t: '',
			p: '',
			a: '',
			r: '',
			html: '',
			e: null,
			_: null,
			v: {},
			rs: [],
			el: function(i) {
				return box.el(this, i);
			},
			rmv: function(i) {
				box.rmv(this, i);
			},
			add: function(v) {
				box.add(this, v);
			}
		};
	$.formLogs = _logs;
	$.form = function(o) {
		var _ = $.extend(true, {}, fn, o || {});
		$.each('load filea fileb success complete ok noup no reset'.split(' '), function(i, v) {
			_[v] = _[v] === false ? false : $.isFunction(_[v]) && _[v] || null;
		});
		if (!_._load) $(function() {
			init(_);
		});
		if (_._load === 1) init(_);
		return _;
	};
})(jQuery);