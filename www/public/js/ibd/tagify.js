/**
 * Tagify (v3.21.4) - tags input component
 * By Yair Even-Or
 * Don't sell this code. (c)
 * https://github.com/yairEO/tagify
 */

!(function (t, e) {
  'object' == typeof exports && 'undefined' != typeof module
    ? (module.exports = e())
    : 'function' == typeof define && define.amd
    ? define(e)
    : ((t = t || self).Tagify = e());
})(this, function () {
  'use strict';
  function t(e) {
    return (t =
      'function' == typeof Symbol && 'symbol' == typeof Symbol.iterator
        ? function (t) {
            return typeof t;
          }
        : function (t) {
            return t && 'function' == typeof Symbol && t.constructor === Symbol && t !== Symbol.prototype ? 'symbol' : typeof t;
          })(e);
  }
  function e(t, e, i) {
    return e in t ? Object.defineProperty(t, e, {value: i, enumerable: !0, configurable: !0, writable: !0}) : (t[e] = i), t;
  }
  function i(t) {
    return (
      (function (t) {
        if (Array.isArray(t)) {
          for (var e = 0, i = new Array(t.length); e < t.length; e++) i[e] = t[e];
          return i;
        }
      })(t) ||
      (function (t) {
        if (Symbol.iterator in Object(t) || '[object Arguments]' === Object.prototype.toString.call(t)) return Array.from(t);
      })(t) ||
      (function () {
        throw new TypeError('Invalid attempt to spread non-iterable instance');
      })()
    );
  }
  var s = function (t, e, i) {
    return i ? t == e : ('' + t).toLowerCase() == ('' + e).toLowerCase();
  };
  function a(t) {
    var e = document.createElement('div');
    return t.replace(/\&#?[0-9a-z]+;/gi, function (t) {
      return (e.innerHTML = t), e.innerText;
    });
  }
  function n(t) {
    return t.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/`|'/g, '&#039;');
  }
  function o(t) {
    return t instanceof Array;
  }
  function r(t) {
    var e = Object.prototype.toString.call(t).split(' ')[1].slice(0, -1);
    return t === Object(t) && 'Array' != e && 'Function' != e && 'RegExp' != e && 'HTMLUnknownElement' != e;
  }
  function l(t, e, i) {
    function s(t, e) {
      for (var i in e)
        if (e.hasOwnProperty(i)) {
          if (r(e[i])) {
            r(t[i]) ? s(t[i], e[i]) : (t[i] = Object.assign({}, e[i]));
            continue;
          }
          if (o(e[i])) {
            t[i] = (o(t[i]) ? t[i] : []).concat(e[i]);
            continue;
          }
          t[i] = e[i];
        }
    }
    return t instanceof Object || (t = {}), s(t, e), i && s(t, i), t;
  }
  function d(t) {
    return String.prototype.normalize ? ('string' == typeof t ? t.normalize('NFD').replace(/[\u0300-\u036f]/g, '') : void 0) : t;
  }
  var c = {
      init: function () {
        (this.DOM.dropdown = this.parseTemplate('dropdown', [this.settings])),
          (this.DOM.dropdown.content = this.DOM.dropdown.querySelector('.' + this.settings.classNames.dropdownWrapper));
      },
      show: function (t) {
        var e,
          i,
          a,
          n = this,
          o = this.settings,
          l = window.getSelection(),
          d = 'mix' == o.mode && !o.enforceWhitelist,
          c = !o.whitelist || !o.whitelist.length,
          h = 'manual' == o.dropdown.position;
        if (
          ((t = void 0 === t ? this.state.inputText : t), (!c || d || o.templates.dropdownItemNoMatch) && !1 !== o.dropdown.enable && !this.state.isLoading)
        ) {
          if (
            (clearTimeout(this.dropdownHide__bindEventsTimeout),
            (this.suggestedListItems = this.dropdown.filterListItems.call(this, t)),
            t &&
              !this.suggestedListItems.length &&
              (this.trigger('dropdown:noMatch', t), o.templates.dropdownItemNoMatch && (a = o.templates.dropdownItemNoMatch.call(this, {value: t}))),
            !a)
          ) {
            if (this.suggestedListItems.length)
              t && d && !this.state.editing.scope && !s(this.suggestedListItems[0].value, t) && this.suggestedListItems.unshift({value: t});
            else {
              if (!t || !d || this.state.editing.scope) return this.input.autocomplete.suggest.call(this), void this.dropdown.hide.call(this);
              this.suggestedListItems = [{value: t}];
            }
            (i = '' + (r((e = this.suggestedListItems[0])) ? e.value : e)),
              o.autoComplete && i && 0 == i.indexOf(t) && this.input.autocomplete.suggest.call(this, e);
          }
          this.dropdown.fill.call(this, a),
            o.dropdown.highlightFirst && this.dropdown.highlightOption.call(this, this.DOM.dropdown.content.children[0]),
            this.state.dropdown.visible || setTimeout(this.dropdown.events.binding.bind(this)),
            (this.state.dropdown.visible = t || !0),
            (this.state.dropdown.query = t),
            (this.state.selection = {anchorOffset: l.anchorOffset, anchorNode: l.anchorNode}),
            h ||
              setTimeout(function () {
                n.dropdown.position.call(n), n.dropdown.render.call(n);
              }),
            setTimeout(function () {
              n.trigger('dropdown:show', n.DOM.dropdown);
            });
        }
      },
      hide: function (t) {
        var e = this,
          i = this.DOM,
          s = i.scope,
          a = i.dropdown,
          n = 'manual' == this.settings.dropdown.position && !t;
        if (a && document.body.contains(a) && !n)
          return (
            window.removeEventListener('resize', this.dropdown.position),
            this.dropdown.events.binding.call(this, !1),
            s.setAttribute('aria-expanded', !1),
            a.parentNode.removeChild(a),
            setTimeout(function () {
              e.state.dropdown.visible = !1;
            }, 100),
            (this.state.dropdown.query = this.state.ddItemData = this.state.ddItemElm = this.state.selection = null),
            this.state.tag && this.state.tag.value.length && (this.state.flaggedTags[this.state.tag.baseOffset] = this.state.tag),
            this.trigger('dropdown:hide', a),
            this
          );
      },
      render: function () {
        var t,
          e,
          i,
          s = this,
          a =
            ((t = this.DOM.dropdown),
            ((i = t.cloneNode(!0)).style.cssText = 'position:fixed; top:-9999px; opacity:0'),
            document.body.appendChild(i),
            (e = i.clientHeight),
            i.parentNode.removeChild(i),
            e),
          n = this.settings;
        return (
          this.DOM.scope.setAttribute('aria-expanded', !0),
          document.body.contains(this.DOM.dropdown) ||
            (this.DOM.dropdown.classList.add(n.classNames.dropdownInital),
            this.dropdown.position.call(this, a),
            n.dropdown.appendTarget.appendChild(this.DOM.dropdown),
            setTimeout(function () {
              return s.DOM.dropdown.classList.remove(n.classNames.dropdownInital);
            })),
          this
        );
      },
      fill: function (t) {
        var e;
        (t = 'string' == typeof t ? t : this.dropdown.createListHTML.call(this, t || this.suggestedListItems)),
          (this.DOM.dropdown.content.innerHTML = (e = t)
            ? e.replace(/\>[\r\n ]+\</g, '><').replace(/(<.*?>)|\s+/g, function (t, e) {
                return e || ' ';
              })
            : '');
      },
      refilter: function (t) {
        (t = t || this.state.dropdown.query || ''),
          (this.suggestedListItems = this.dropdown.filterListItems.call(this, t)),
          this.suggestedListItems.length ? this.dropdown.fill.call(this) : this.dropdown.hide.call(this),
          this.trigger('dropdown:updated', this.DOM.dropdown);
      },
      position: function (t) {
        if ('manual' != this.settings.dropdown.position) {
          var e,
            i,
            s,
            a,
            n,
            o,
            r,
            l = this.DOM.dropdown,
            d = document.documentElement.clientHeight,
            c = Math.max(document.documentElement.clientWidth || 0, window.innerWidth || 0) > 480 ? this.settings.dropdown.position : 'all',
            h = this.DOM['input' == c ? 'input' : 'scope'];
          (t = t || l.clientHeight),
            this.state.dropdown.visible &&
              ('text' == c
                ? ((a = (i = this.getCaretGlobalPosition()).bottom), (s = i.top), (n = i.left), (o = 'auto'))
                : ((r = (function (t) {
                    for (var e = 0, i = 0; t; ) (e += t.offsetLeft || 0), (i += t.offsetTop || 0), (t = t.parentNode);
                    return {left: e, top: i};
                  })(this.settings.dropdown.appendTarget)),
                  (s = (i = h.getBoundingClientRect()).top + 2 - r.top),
                  (a = i.bottom - 1 - r.top),
                  (n = i.left - r.left),
                  (o = i.width + 'px')),
              (s = Math.floor(s)),
              (a = Math.ceil(a)),
              (e = d - i.bottom < t),
              (l.style.cssText =
                'left:' +
                (n + window.pageXOffset) +
                'px; width:' +
                o +
                ';' +
                (e ? 'top: ' + (s + window.pageYOffset) + 'px' : 'top: ' + (a + window.pageYOffset) + 'px')),
              l.setAttribute('placement', e ? 'top' : 'bottom'),
              l.setAttribute('position', c));
        }
      },
      events: {
        binding: function () {
          var t = !(arguments.length > 0 && void 0 !== arguments[0]) || arguments[0],
            e = this.dropdown.events.callbacks,
            i = (this.listeners.dropdown = this.listeners.dropdown || {
              position: this.dropdown.position.bind(this),
              onKeyDown: e.onKeyDown.bind(this),
              onMouseOver: e.onMouseOver.bind(this),
              onMouseLeave: e.onMouseLeave.bind(this),
              onClick: e.onClick.bind(this),
              onScroll: e.onScroll.bind(this),
            }),
            s = t ? 'addEventListener' : 'removeEventListener';
          'manual' != this.settings.dropdown.position && (window[s]('resize', i.position), window[s]('keydown', i.onKeyDown)),
            this.DOM.dropdown[s]('mouseover', i.onMouseOver),
            this.DOM.dropdown[s]('mouseleave', i.onMouseLeave),
            this.DOM.dropdown[s]('mousedown', i.onClick),
            this.DOM.dropdown.content[s]('scroll', i.onScroll);
        },
        callbacks: {
          onKeyDown: function (t) {
            var e = this.DOM.dropdown.querySelector('.' + this.settings.classNames.dropdownItemActive),
              i = e;
            switch (t.key) {
              case 'ArrowDown':
              case 'ArrowUp':
              case 'Down':
              case 'Up':
                var s;
                t.preventDefault(),
                  i && (i = i[('ArrowUp' == t.key || 'Up' == t.key ? 'previous' : 'next') + 'ElementSibling']),
                  i || (i = (s = this.DOM.dropdown.content.children)['ArrowUp' == t.key || 'Up' == t.key ? s.length - 1 : 0]),
                  this.dropdown.highlightOption.call(this, i, !0);
                break;
              case 'Escape':
              case 'Esc':
                this.dropdown.hide.call(this);
                break;
              case 'ArrowRight':
                if (this.state.actions.ArrowLeft) return;
              case 'Tab':
                if ('mix' != this.settings.mode && i && !this.settings.autoComplete.rightKey && !this.state.editing) {
                  t.preventDefault();
                  var a = i.getAttribute('tagifySuggestionIdx'),
                    n = a ? this.suggestedListItems[+a] : '';
                  return this.input.autocomplete.set.call(this, n.value || n), !1;
                }
                return !0;
              case 'Enter':
                t.preventDefault(), this.dropdown.selectOption.call(this, e);
                break;
              case 'Backspace':
                if ('mix' == this.settings.mode || this.state.editing.scope) return;
                var o = this.state.inputText.trim();
                ('' != o && 8203 != o.charCodeAt(0)) ||
                  (!0 === this.settings.backspace ? this.removeTags() : 'edit' == this.settings.backspace && setTimeout(this.editTag.bind(this), 0));
            }
          },
          onMouseOver: function (t) {
            var e = t.target.closest('.' + this.settings.classNames.dropdownItem);
            e && this.dropdown.highlightOption.call(this, e);
          },
          onMouseLeave: function (t) {
            this.dropdown.highlightOption.call(this);
          },
          onClick: function (t) {
            var e = this;
            if (0 == t.button && t.target != this.DOM.dropdown) {
              var i = t.target.closest('.' + this.settings.classNames.dropdownItem);
              (this.state.actions.selectOption = !0),
                setTimeout(function () {
                  return (e.state.actions.selectOption = !1);
                }, 50),
                this.settings.hooks
                  .suggestionClick(t, {tagify: this, suggestionElm: i})
                  .then(function () {
                    i && e.dropdown.selectOption.call(e, i);
                  })
                  .catch(function (t) {
                    return t;
                  });
            }
          },
          onScroll: function (t) {
            var e = t.target,
              i = (e.scrollTop / (e.scrollHeight - e.parentNode.clientHeight)) * 100;
            this.trigger('dropdown:scroll', {percentage: Math.round(i)});
          },
        },
      },
      highlightOption: function (t, e) {
        var i,
          s = this.settings.classNames.dropdownItemActive;
        if ((this.state.ddItemElm && (this.state.ddItemElm.classList.remove(s), this.state.ddItemElm.removeAttribute('aria-selected')), !t))
          return (this.state.ddItemData = null), (this.state.ddItemElm = null), void this.input.autocomplete.suggest.call(this);
        (i = this.suggestedListItems[this.getNodeIndex(t)]),
          (this.state.ddItemData = i),
          (this.state.ddItemElm = t),
          t.classList.add(s),
          t.setAttribute('aria-selected', !0),
          e && (t.parentNode.scrollTop = t.clientHeight + t.offsetTop - t.parentNode.clientHeight),
          this.settings.autoComplete && (this.input.autocomplete.suggest.call(this, i), this.dropdown.position.call(this));
      },
      selectOption: function (t) {
        var e = this,
          i = this.settings.dropdown,
          s = i.clearOnSelect,
          a = i.closeOnSelect;
        if (!t) return this.addTags(this.state.inputText, !0), void (a && this.dropdown.hide.call(this));
        var n = t.getAttribute('tagifySuggestionIdx'),
          o = this.suggestedListItems[+n];
        if ((this.trigger('dropdown:select', {data: o, elm: t}), n && o)) {
          if (
            (this.state.editing ? this.onEditTagDone(null, l({__isValid: !0}, o)) : this.addTags([o], s),
            setTimeout(function () {
              e.DOM.input.focus(), e.toggleFocusClass(!0);
            }),
            a)
          )
            return this.dropdown.hide.call(this);
          this.dropdown.refilter.call(this);
        }
      },
      selectAll: function () {
        return (this.suggestedListItems.length = 0), this.dropdown.hide.call(this), this.addTags(this.dropdown.filterListItems.call(this, ''), !0), this;
      },
      filterListItems: function (t, e) {
        var i,
          s,
          a,
          n,
          o,
          l = this,
          c = this.settings,
          h = c.dropdown,
          g = ((e = e || {}), []),
          u = c.whitelist,
          p = h.maxItems || 1 / 0,
          f = h.searchKeys,
          m = 0;
        if (!t || !f.length)
          return (c.duplicates
            ? u
            : u.filter(function (t) {
                return !l.isTagDuplicate(r(t) ? t.value : t);
              })
          ).slice(0, p);
        function v(t, e) {
          return e
            .toLowerCase()
            .split(' ')
            .every(function (e) {
              return t.includes(e.toLowerCase());
            });
        }
        for (
          o = h.caseSensitive ? '' + t : ('' + t).toLowerCase();
          m < u.length &&
          ((i = u[m] instanceof Object ? u[m] : {value: u[m]}),
          h.fuzzySearch && !e.exact
            ? ((a = f
                .reduce(function (t, e) {
                  return t + ' ' + (i[e] || '');
                }, '')
                .toLowerCase()),
              h.accentedSearch && ((a = d(a)), (o = d(o))),
              (s = v(a, o)))
            : (s = f.some(function (t) {
                var s = '' + (i[t] || '');
                return h.accentedSearch && ((s = d(s)), (o = d(o))), h.caseSensitive || (s = s.toLowerCase()), e.exact ? s == o : 0 == s.indexOf(o);
              })),
          (n = !c.duplicates && this.isTagDuplicate(r(i) ? i.value : i)),
          s && !n && p-- && g.push(i),
          0 != p);
          m++
        );
        return g;
      },
      createListHTML: function (t) {
        var e = this;
        return t
          .map(function (t, i) {
            ('string' != typeof t && 'number' != typeof t) || (t = {value: t});
            var s = e.settings.dropdown.mapValueTo,
              a = s ? ('function' == typeof s ? s(t) : t[s]) : t.value;
            t.value = a && 'string' == typeof a ? n(a) : a;
            var o = e.settings.templates.dropdownItem.call(e, t);
            return (o = o.replace(/\s*tagifySuggestionIdx=(["'])(.*?)\1/gim, '').replace('>', ' tagifySuggestionIdx="'.concat(i, '">')));
          })
          .join('');
      },
    },
    h = {
      delimiters: ',',
      pattern: null,
      tagTextProp: 'value',
      maxTags: 1 / 0,
      callbacks: {},
      addTagOnBlur: !0,
      duplicates: !1,
      whitelist: [],
      blacklist: [],
      enforceWhitelist: !1,
      keepInvalidTags: !1,
      mixTagsAllowedAfter: /,|\.|\:|\s/,
      mixTagsInterpolator: ['[[', ']]'],
      backspace: !0,
      skipInvalid: !1,
      editTags: {clicks: 2, keepInvalid: !0},
      transformTag: function () {},
      trim: !0,
      mixMode: {insertAfterTag: ' '},
      autoComplete: {enabled: !0, rightKey: !1},
      classNames: {
        namespace: 'tagify',
        input: 'tagify__input',
        focus: 'tagify--focus',
        tag: 'tagify__tag',
        tagNoAnimation: 'tagify--noAnim',
        tagInvalid: 'tagify--invalid',
        tagNotAllowed: 'tagify--notAllowed',
        inputInvalid: 'tagify__input--invalid',
        tagX: 'tagify__tag__removeBtn',
        tagText: 'tagify__tag-text',
        dropdown: 'tagify__dropdown',
        dropdownWrapper: 'tagify__dropdown__wrapper',
        dropdownItem: 'tagify__dropdown__item',
        dropdownItemActive: 'tagify__dropdown__item--active',
        dropdownInital: 'tagify__dropdown--initial',
        scopeLoading: 'tagify--loading',
        tagLoading: 'tagify__tag--loading',
        tagEditing: 'tagify__tag--editable',
        tagFlash: 'tagify__tag--flash',
        tagHide: 'tagify__tag--hide',
        hasMaxTags: 'tagify--hasMaxTags',
        hasNoTags: 'tagify--noTags',
        empty: 'tagify--empty',
      },
      dropdown: {
        classname: '',
        enabled: 2,
        maxItems: 10,
        searchKeys: ['value', 'searchBy'],
        fuzzySearch: !0,
        caseSensitive: !1,
        accentedSearch: !0,
        highlightFirst: !1,
        closeOnSelect: !0,
        clearOnSelect: !0,
        position: 'all',
        appendTarget: null,
      },
      hooks: {
        beforeRemoveTag: function () {
          return Promise.resolve();
        },
        suggestionClick: function () {
          return Promise.resolve();
        },
      },
    };
  var g = {
    customBinding: function () {
      var t = this;
      this.customEventsList.forEach(function (e) {
        t.on(e, t.settings.callbacks[e]);
      });
    },
    binding: function () {
      var t,
        e = !(arguments.length > 0 && void 0 !== arguments[0]) || arguments[0],
        i = this.events.callbacks,
        s = e ? 'addEventListener' : 'removeEventListener';
      if (!this.state.mainEvents || !e)
        for (var a in ((this.state.mainEvents = e),
        e &&
          !this.listeners.main &&
          (this.DOM.input.addEventListener(this.isIE ? 'keydown' : 'input', i[this.isIE ? 'onInputIE' : 'onInput'].bind(this)),
          this.settings.isJQueryPlugin && jQuery(this.DOM.originalInput).on('tagify.removeAllTags', this.removeAllTags.bind(this))),
        (t = this.listeners.main = this.listeners.main || {
          focus: ['input', i.onFocusBlur.bind(this)],
          blur: ['input', i.onFocusBlur.bind(this)],
          keydown: ['input', i.onKeydown.bind(this)],
          click: ['scope', i.onClickScope.bind(this)],
          dblclick: ['scope', i.onDoubleClickScope.bind(this)],
          paste: ['input', i.onPaste.bind(this)],
        })))
          ('blur' != a || e) && this.DOM[t[a][0]][s](a, t[a][1]);
    },
    callbacks: {
      onFocusBlur: function (t) {
        var e = t.target ? this.trim(t.target.textContent) : '',
          i = this.settings,
          s = t.type,
          a = i.dropdown.enabled >= 0,
          n = {relatedTarget: t.relatedTarget},
          o = this.state.actions.selectOption && (a || !i.dropdown.closeOnSelect),
          r = this.state.actions.addNew && a,
          l = window.getSelection();
        if ('blur' == s) {
          if (t.relatedTarget === this.DOM.scope) return this.dropdown.hide.call(this), void this.DOM.input.focus();
          this.postUpdate(), this.triggerChangeEvent();
        }
        if (!o && !r)
          if (((this.state.hasFocus = 'focus' == s && +new Date()), this.toggleFocusClass(this.state.hasFocus), 'mix' != i.mode)) {
            if ('focus' == s) return this.trigger('focus', n), void (0 === i.dropdown.enabled && this.dropdown.show.call(this));
            'blur' == s &&
              (this.trigger('blur', n),
              this.loading(!1),
              ('select' == this.settings.mode ? !this.value.length || this.value[0].value != e : e && !this.state.actions.selectOption && i.addTagOnBlur) &&
                this.addTags(e, !0)),
              this.DOM.input.removeAttribute('style'),
              this.dropdown.hide.call(this);
          } else
            'focus' == s
              ? this.trigger('focus', n)
              : 'blur' == t.type &&
                (this.trigger('blur', n),
                this.loading(!1),
                this.dropdown.hide.call(this),
                (this.state.dropdown.visible = void 0),
                (this.state.selection = {anchorOffset: l.anchorOffset, anchorNode: l.anchorNode}),
                l.getRangeAt && l.rangeCount && (this.state.selection.range = l.getRangeAt(0)));
      },
      onKeydown: function (t) {
        var e = this,
          i = this.trim(t.target.textContent);
        if ((this.trigger('keydown', {originalEvent: this.cloneEvent(t)}), 'mix' == this.settings.mode)) {
          switch (t.key) {
            case 'Left':
            case 'ArrowLeft':
              this.state.actions.ArrowLeft = !0;
              break;
            case 'Delete':
            case 'Backspace':
              if (this.state.editing) return;
              var s,
                n = document.getSelection(),
                o = 'Delete' == t.key && n.anchorOffset == (n.anchorNode.length || 0),
                r = 1 == n.anchorNode.nodeType || (!n.anchorOffset && n.anchorNode.previousElementSibling),
                l = a(this.DOM.input.innerHTML),
                d = this.getTagElms();
              if ('BR' == n.anchorNode.nodeName) return;
              if (
                ((o || r) && 1 == n.anchorNode.nodeType
                  ? (s = 0 == n.anchorOffset ? (o ? d[0] : null) : d[n.anchorOffset - 1])
                  : o
                  ? (s = n.anchorNode.nextElementSibling)
                  : r && (s = r),
                3 == n.anchorNode.nodeType && !n.anchorNode.nodeValue && n.anchorNode.previousElementSibling && t.preventDefault(),
                (r || o) && !this.settings.backspace)
              )
                return void t.preventDefault();
              if ('Range' != n.type && s && s.hasAttribute('readonly'))
                return void this.placeCaretAfterNode(
                  (function (t, e) {
                    for (e = e || 'previous'; (t = t[e + 'Sibling']); ) if (3 == t.nodeType) return t;
                  })(s),
                );
              this.isFirefox && 1 == n.anchorNode.nodeType && 0 != n.anchorOffset && (this.removeTags(), this.placeCaretAfterNode(this.setRangeAtStartEnd())),
                setTimeout(function () {
                  var t = document.getSelection(),
                    i = a(e.DOM.input.innerHTML),
                    s = t.anchorNode.previousElementSibling;
                  if (
                    i.length >= l.length &&
                    s &&
                    !s.hasAttribute('readonly') &&
                    (e.removeTags(s), e.fixFirefoxLastTagNoCaret(), 2 == e.DOM.input.children.length && 'BR' == e.DOM.input.children[1].tagName)
                  )
                    return (e.DOM.input.innerHTML = ''), (e.value.length = 0), !0;
                  e.value = [].map
                    .call(d, function (t, i) {
                      var s = e.tagData(t);
                      if (t.parentNode || s.readonly) return s;
                      e.trigger('remove', {tag: t, index: i, data: s});
                    })
                    .filter(function (t) {
                      return t;
                    });
                }, 50);
          }
          return !0;
        }
        switch (t.key) {
          case 'Backspace':
            (this.state.dropdown.visible && 'manual' != this.settings.dropdown.position) ||
              ('' != i && 8203 != i.charCodeAt(0)) ||
              (!0 === this.settings.backspace ? this.removeTags() : 'edit' == this.settings.backspace && setTimeout(this.editTag.bind(this), 0));
            break;
          case 'Esc':
          case 'Escape':
            if (this.state.dropdown.visible) return;
            t.target.blur();
            break;
          case 'Down':
          case 'ArrowDown':
            this.state.dropdown.visible || this.dropdown.show.call(this);
            break;
          case 'ArrowRight':
            var c = this.state.inputSuggestion || this.state.ddItemData;
            if (c && this.settings.autoComplete.rightKey) return void this.addTags([c], !0);
            break;
          case 'Tab':
            if ((i && t.preventDefault(), !i || 'select' == this.settings.mode)) return !0;
          case 'Enter':
            if (this.state.dropdown.visible || 229 == t.keyCode) return;
            t.preventDefault(),
              setTimeout(function () {
                e.state.actions.selectOption || e.addTags(i, !0);
              });
        }
      },
      onInput: function (t) {
        if ('mix' == this.settings.mode) return this.events.callbacks.onMixTagsInput.call(this, t);
        var e = this.input.normalize.call(this),
          i = e.length >= this.settings.dropdown.enabled,
          s = {value: e, inputElm: this.DOM.input};
        (s.isValid = this.validateTag({value: e})),
          this.trigger('input', s),
          this.state.inputText != e &&
            (this.input.set.call(this, e, !1),
            -1 != e.search(this.settings.delimiters)
              ? this.addTags(e) && this.input.set.call(this)
              : this.settings.dropdown.enabled >= 0 && this.dropdown[i ? 'show' : 'hide'].call(this, e));
      },
      onMixTagsInput: function (t) {
        var e,
          i,
          s,
          a,
          n,
          o,
          r,
          d,
          c = this,
          h = this.settings,
          g = this.value.length,
          u = this.getTagElms(),
          p = document.createDocumentFragment(),
          f = window.getSelection().getRangeAt(0),
          m = [].map.call(u, function (t) {
            return c.tagData(t).value;
          });
        if (
          (this.value.slice().forEach(function (t) {
            t.readonly && !m.includes(t.value) && p.appendChild(c.createTagElem(t));
          }),
          p.childNodes.length && (f.insertNode(p), this.setRangeAtStartEnd(!1, p.lastChild)),
          u.length != g)
        )
          return (
            (this.value = [].map.call(this.getTagElms(), function (t) {
              return c.tagData(t);
            })),
            void this.update({withoutChangeEvent: !0})
          );
        if (this.hasMaxTags()) return !0;
        if (window.getSelection && (o = window.getSelection()).rangeCount > 0 && 3 == o.anchorNode.nodeType) {
          if (
            ((f = o.getRangeAt(0).cloneRange()).collapse(!0),
            f.setStart(o.focusNode, 0),
            (s = (e = f.toString().slice(0, f.endOffset)).split(h.pattern).length - 1),
            (i = e.match(h.pattern)) && (a = e.slice(e.lastIndexOf(i[i.length - 1]))),
            a)
          ) {
            if (
              ((this.state.actions.ArrowLeft = !1),
              (this.state.tag = {prefix: a.match(h.pattern)[0], value: a.replace(h.pattern, '')}),
              (this.state.tag.baseOffset = o.baseOffset - this.state.tag.value.length),
              (d = this.state.tag.value.match(h.delimiters)))
            )
              return (
                (this.state.tag.value = this.state.tag.value.replace(h.delimiters, '')),
                (this.state.tag.delimiters = d[0]),
                this.addTags(this.state.tag.value, h.dropdown.clearOnSelect),
                void this.dropdown.hide.call(this)
              );
            n = this.state.tag.value.length >= h.dropdown.enabled;
            try {
              (r = (r = this.state.flaggedTags[this.state.tag.baseOffset]).prefix == this.state.tag.prefix && r.value[0] == this.state.tag.value[0]),
                this.state.flaggedTags[this.state.tag.baseOffset] && !this.state.tag.value && delete this.state.flaggedTags[this.state.tag.baseOffset];
            } catch (t) {}
            (r || s < this.state.mixMode.matchedPatternCount) && (n = !1);
          } else this.state.flaggedTags = {};
          this.state.mixMode.matchedPatternCount = s;
        }
        setTimeout(function () {
          c.update({withoutChangeEvent: !0}),
            c.trigger('input', l({}, c.state.tag, {textContent: c.DOM.input.textContent})),
            c.state.tag && c.dropdown[n ? 'show' : 'hide'].call(c, c.state.tag.value);
        }, 10);
      },
      onInputIE: function (t) {
        var e = this;
        setTimeout(function () {
          e.events.callbacks.onInput.call(e, t);
        });
      },
      onClickScope: function (t) {
        var e = this.settings,
          i = t.target.closest('.' + e.classNames.tag),
          s = +new Date() - this.state.hasFocus;
        if (t.target != this.DOM.scope) {
          if (!t.target.classList.contains(e.classNames.tagX))
            return i
              ? (this.trigger('click', {tag: i, index: this.getNodeIndex(i), data: this.tagData(i), originalEvent: this.cloneEvent(t)}),
                void ((1 !== e.editTags && 1 !== e.editTags.clicks) || this.events.callbacks.onDoubleClickScope.call(this, t)))
              : void (t.target == this.DOM.input && ('mix' == e.mode && this.fixFirefoxLastTagNoCaret(), s > 500)
                  ? this.state.dropdown.visible
                    ? this.dropdown.hide.call(this)
                    : 0 === e.dropdown.enabled && 'mix' != e.mode && this.dropdown.show.call(this)
                  : 'select' == e.mode && !this.state.dropdown.visible && this.dropdown.show.call(this));
          this.removeTags(t.target.parentNode);
        } else this.state.hasFocus || this.DOM.input.focus();
      },
      onPaste: function (t) {
        var e;
        t.preventDefault(),
          this.settings.readonly ||
            ((e = (t.clipboardData || window.clipboardData).getData('Text')),
            this.injectAtCaret(e, window.getSelection().getRangeAt(0)),
            'mix' != this.settings.mode && this.addTags(this.DOM.input.textContent, !0));
      },
      onEditTagInput: function (t, i) {
        var s = t.closest('.' + this.settings.classNames.tag),
          a = this.getNodeIndex(s),
          n = this.tagData(s),
          o = this.input.normalize.call(this, t),
          r = s.innerHTML != s.__tagifyTagData.__originalHTML,
          d = this.validateTag(e({}, this.settings.tagTextProp, o));
        r || !0 !== t.originalIsValid || (d = !0),
          s.classList.toggle(this.settings.classNames.tagInvalid, !0 !== d),
          (n.__isValid = d),
          (s.title = !0 === d ? n.title || n.value : d),
          o.length >= this.settings.dropdown.enabled && ((this.state.editing.value = o), this.dropdown.show.call(this, o)),
          this.trigger('edit:input', {tag: s, index: a, data: l({}, this.value[a], {newValue: o}), originalEvent: this.cloneEvent(i)});
      },
      onEditTagFocus: function (t) {
        this.state.editing = {scope: t, input: t.querySelector('[contenteditable]')};
      },
      onEditTagBlur: function (t) {
        var i;
        if ((this.state.hasFocus || this.toggleFocusClass(), this.DOM.scope.contains(t))) {
          var s,
            a = this.settings,
            n = t.closest('.' + a.classNames.tag),
            o = this.input.normalize.call(this, t),
            r = this.tagData(n).__originalData,
            l = n.innerHTML != n.__tagifyTagData.__originalHTML,
            d = this.validateTag(e({}, a.tagTextProp, o));
          if (o)
            if (l) {
              if (
                ((s = this.getWhitelistItem(o) || (e((i = {}), a.tagTextProp, o), e(i, 'value', o), i)),
                a.transformTag.call(this, s, r),
                !0 !== (d = this.validateTag(e({}, a.tagTextProp, s[a.tagTextProp]))))
              ) {
                if ((this.trigger('invalid', {data: s, tag: n, message: d}), a.editTags.keepInvalid)) return;
                a.keepInvalidTags ? (s.__isValid = d) : (s = r);
              }
              this.onEditTagDone(n, s);
            } else this.onEditTagDone(n, r);
          else this.onEditTagDone(n);
        }
      },
      onEditTagkeydown: function (t, e) {
        switch ((this.trigger('edit:keydown', {originalEvent: this.cloneEvent(t)}), t.key)) {
          case 'Esc':
          case 'Escape':
            e.innerHTML = e.__tagifyTagData.__originalHTML;
          case 'Enter':
          case 'Tab':
            t.preventDefault(), t.target.blur();
        }
      },
      onDoubleClickScope: function (t) {
        var e,
          i,
          s = t.target.closest('.' + this.settings.classNames.tag),
          a = this.settings;
        s &&
          ((e = s.classList.contains(this.settings.classNames.tagEditing)),
          (i = s.hasAttribute('readonly')),
          'select' == a.mode || a.readonly || e || i || !this.settings.editTags || this.editTag(s),
          this.toggleFocusClass(!0),
          this.trigger('dblclick', {tag: s, index: this.getNodeIndex(s), data: this.tagData(s)}));
      },
    },
  };
  function u(e, i) {
    return e
      ? e.previousElementSibling && e.previousElementSibling.classList.contains('tagify')
        ? (console.warn('Tagify: ', 'input element is already Tagified', e), this)
        : (l(
            this,
            (function (e) {
              var i = document.createTextNode('');
              function s(t, e, s) {
                s &&
                  e.split(/\s+/g).forEach(function (e) {
                    return i[t + 'EventListener'].call(i, e, s);
                  });
              }
              return {
                off: function (t, e) {
                  return s('remove', t, e), this;
                },
                on: function (t, e) {
                  return e && 'function' == typeof e && s('add', t, e), this;
                },
                trigger: function (s, a) {
                  var n;
                  if (s)
                    if (e.settings.isJQueryPlugin) 'remove' == s && (s = 'removeTag'), jQuery(e.DOM.originalInput).triggerHandler(s, [a]);
                    else {
                      try {
                        var o = l({}, 'object' === t(a) ? a : {value: a});
                        if (((o.tagify = this), a instanceof Object)) for (var r in a) a[r] instanceof HTMLElement && (o[r] = a[r]);
                        n = new CustomEvent(s, {detail: o});
                      } catch (t) {
                        console.warn(t);
                      }
                      i.dispatchEvent(n);
                    }
                },
              };
            })(this),
          ),
          (this.isFirefox = 'undefined' != typeof InstallTrigger),
          (this.isIE = window.document.documentMode),
          this.applySettings(e, i || {}),
          (this.state = {inputText: '', editing: !1, actions: {}, mixMode: {}, dropdown: {}, flaggedTags: {}}),
          (this.value = []),
          (this.listeners = {}),
          (this.DOM = {}),
          this.build(e),
          this.getCSSVars(),
          this.loadOriginalValues(),
          this.events.customBinding.call(this),
          this.events.binding.call(this),
          void (e.autofocus && this.DOM.input.focus()))
      : (console.warn('Tagify: ', 'input element not found', e), this);
  }
  return (
    (u.prototype = {
      dropdown: c,
      TEXTS: {empty: 'empty', exceed: 'number of tags exceeded', pattern: 'pattern mismatch', duplicate: 'already exists', notAllowed: 'not allowed'},
      DEFAULTS: h,
      customEventsList: [
        'change',
        'add',
        'remove',
        'invalid',
        'input',
        'click',
        'keydown',
        'focus',
        'blur',
        'edit:input',
        'edit:updated',
        'edit:start',
        'edit:keydown',
        'dropdown:show',
        'dropdown:hide',
        'dropdown:select',
        'dropdown:updated',
        'dropdown:noMatch',
      ],
      trim: function (t) {
        return this.settings.trim && t && 'string' == typeof t ? t.trim() : t;
      },
      parseHTML: function (t) {
        return new DOMParser().parseFromString(t.trim(), 'text/html').body.firstElementChild;
      },
      templates: {
        wrapper: function (t, e) {
          return '<tags class="'
            .concat(e.classNames.namespace, ' ')
            .concat(e.mode ? ''.concat(e.classNames.namespace, '--').concat(e.mode) : '', ' ')
            .concat(t.className, '"\n                    ')
            .concat(e.readonly ? 'readonly' : '', '\n                    ')
            .concat(e.required ? 'required' : '', '\n                    tabIndex="-1">\n            <span ')
            .concat(e.readonly && 'mix' == e.mode ? '' : 'contenteditable', ' data-placeholder="')
            .concat(e.placeholder || '&#8203;', '" aria-placeholder="')
            .concat(e.placeholder || '', '"\n                class="')
            .concat(e.classNames.input, '"\n                role="textbox"\n                aria-autocomplete="both"\n                aria-multiline="')
            .concat('mix' == e.mode, '"></span>\n        </tags>');
        },
        tag: function (t) {
          return '<tag title="'
            .concat(
              t.title || t.value,
              '"\n                    contenteditable=\'false\'\n                    spellcheck=\'false\'\n                    tabIndex="-1"\n                    class="',
            )
            .concat(this.settings.classNames.tag, ' ')
            .concat(t.class ? t.class : '', '"\n                    ')
            .concat(this.getAttributes(t), ">\n            <x title='' class=\"")
            .concat(this.settings.classNames.tagX, "\" role='button' aria-label='remove tag'></x>\n            <div>\n                <span class=\"")
            .concat(this.settings.classNames.tagText, '">')
            .concat(t[this.settings.tagTextProp] || t.value, '</span>\n            </div>\n        </tag>');
        },
        dropdown: function (t) {
          var e = t.dropdown,
            i = 'manual' == e.position,
            s = ''.concat(t.classNames.dropdown);
          return '<div class="'
            .concat(i ? '' : s, ' ')
            .concat(e.classname, '" role="listbox" aria-labelledby="dropdown">\n                    <div class="')
            .concat(t.classNames.dropdownWrapper, '"></div>\n                </div>');
        },
        dropdownItem: function (t) {
          return '<div '
            .concat(this.getAttributes(t), "\n                    class='")
            .concat(this.settings.classNames.dropdownItem, ' ')
            .concat(t.class ? t.class : '', '\'\n                    tabindex="0"\n                    role="option">')
            .concat(t.value, '</div>');
        },
        dropdownItemNoMatch: null,
      },
      parseTemplate: function (t, e) {
        return (t = this.settings.templates[t] || t), this.parseHTML(t.apply(this, e));
      },
      applySettings: function (t, e) {
        this.DEFAULTS.templates = this.templates;
        var i = (this.settings = l({}, this.DEFAULTS, e));
        if (
          ((i.readonly = t.hasAttribute('readonly')),
          (i.placeholder = t.getAttribute('placeholder') || i.placeholder || ''),
          (i.required = t.hasAttribute('required')),
          this.isIE && (i.autoComplete = !1),
          ['whitelist', 'blacklist'].forEach(function (e) {
            var s = t.getAttribute('data-' + e);
            s && (s = s.split(i.delimiters)) instanceof Array && (i[e] = s);
          }),
          'autoComplete' in e && !r(e.autoComplete) && ((i.autoComplete = this.DEFAULTS.autoComplete), (i.autoComplete.enabled = e.autoComplete)),
          'mix' == i.mode && ((i.autoComplete.rightKey = !0), (i.delimiters = e.delimiters || null)),
          t.pattern)
        )
          try {
            i.pattern = new RegExp(t.pattern);
          } catch (t) {}
        if (this.settings.delimiters)
          try {
            i.delimiters = new RegExp(this.settings.delimiters, 'g');
          } catch (t) {}
        'select' == i.mode && (i.dropdown.enabled = 0),
          (i.dropdown.appendTarget = e.dropdown && e.dropdown.appendTarget ? e.dropdown.appendTarget : document.body);
      },
      getAttributes: function (t) {
        if ('[object Object]' != Object.prototype.toString.call(t)) return '';
        var e,
          i,
          s = Object.keys(t),
          a = '';
        for (i = s.length; i--; )
          'class' != (e = s[i]) && t.hasOwnProperty(e) && void 0 !== t[e] && (a += ' ' + e + (void 0 !== t[e] ? '="'.concat(t[e], '"') : ''));
        return a;
      },
      getCaretGlobalPosition: function () {
        var t = document.getSelection();
        if (t.rangeCount) {
          var e,
            i,
            s = t.getRangeAt(0),
            a = s.startContainer,
            n = s.startOffset;
          if (n > 0)
            return (i = document.createRange()).setStart(a, n - 1), i.setEnd(a, n), {left: (e = i.getBoundingClientRect()).right, top: e.top, bottom: e.bottom};
          if (a.getBoundingClientRect) return a.getBoundingClientRect();
        }
        return {left: -9999, top: -9999};
      },
      getCSSVars: function () {
        var t,
          e = getComputedStyle(this.DOM.scope, null);
        this.CSSVars = {
          tagHideTransition: (function (t) {
            var e = t.value;
            return 's' == t.unit ? 1e3 * e : e;
          })(
            (function (t) {
              if (!t) return {};
              var e = (t = t.trim().split(' ')[0])
                .split(/\d+/g)
                .filter(function (t) {
                  return t;
                })
                .pop()
                .trim();
              return {
                value: +t
                  .split(e)
                  .filter(function (t) {
                    return t;
                  })[0]
                  .trim(),
                unit: e,
              };
            })(((t = 'tag-hide-transition'), e.getPropertyValue('--' + t))),
          ),
        };
      },
      build: function (t) {
        var e = this.DOM;
        this.settings.mixMode.integrated
          ? ((e.originalInput = null), (e.scope = t), (e.input = t))
          : ((e.originalInput = t),
            (e.scope = this.parseTemplate('wrapper', [t, this.settings])),
            (e.input = e.scope.querySelector('.' + this.settings.classNames.input)),
            t.parentNode.insertBefore(e.scope, t)),
          this.settings.dropdown.enabled >= 0 && this.dropdown.init.call(this);
      },
      destroy: function () {
        this.DOM.scope.parentNode.removeChild(this.DOM.scope), this.dropdown.hide.call(this, !0), clearTimeout(this.dropdownHide__bindEventsTimeout);
      },
      loadOriginalValues: function (t) {
        var e,
          i = this.settings;
        if ((t = t || (i.mixMode.integrated ? this.DOM.input.textContent : this.DOM.originalInput.value)))
          if ((this.removeAllTags(), 'mix' == i.mode))
            this.parseMixTags(t.trim()), ((e = this.DOM.input.lastChild) && 'BR' == e.tagName) || this.DOM.input.insertAdjacentHTML('beforeend', '<br>');
          else {
            try {
              JSON.parse(t) instanceof Array && (t = JSON.parse(t));
            } catch (t) {}
            this.addTags(t).forEach(function (t) {
              return t && t.classList.add(i.classNames.tagNoAnimation);
            });
          }
        else this.postUpdate();
        (this.state.lastOriginalValueReported = i.mixMode.integrated ? '' : this.DOM.originalInput.value), (this.state.loadedOriginalValues = !0);
      },
      cloneEvent: function (t) {
        var e = {};
        for (var i in t) e[i] = t[i];
        return e;
      },
      loading: function (t) {
        return (this.state.isLoading = t), this.DOM.scope.classList[t ? 'add' : 'remove'](this.settings.classNames.scopeLoading), this;
      },
      tagLoading: function (t, e) {
        return t && t.classList[e ? 'add' : 'remove'](this.settings.classNames.tagLoading), this;
      },
      toggleClass: function (t, e) {
        'string' == typeof t && this.DOM.scope.classList.toggle(t, e);
      },
      toggleFocusClass: function (t) {
        this.toggleClass(this.settings.classNames.focus, !!t);
      },
      triggerChangeEvent: function () {
        if (!this.settings.mixMode.integrated) {
          var t = this.DOM.originalInput,
            e = this.state.lastOriginalValueReported !== t.value,
            i = new CustomEvent('change', {bubbles: !0});
          e &&
            ((this.state.lastOriginalValueReported = t.value),
            (i.simulated = !0),
            t._valueTracker && t._valueTracker.setValue(Math.random()),
            t.dispatchEvent(i),
            this.trigger('change', this.state.lastOriginalValueReported),
            (t.value = this.state.lastOriginalValueReported));
        }
      },
      events: g,
      fixFirefoxLastTagNoCaret: function () {},
      placeCaretAfterNode: function (t) {
        if (t) {
          var e = t.nextSibling,
            i = window.getSelection(),
            s = i.getRangeAt(0);
          i.rangeCount && (s.setStartBefore(e || t), s.setEndBefore(e || t), i.removeAllRanges(), i.addRange(s));
        }
      },
      insertAfterTag: function (t, e) {
        if (((e = e || this.settings.mixMode.insertAfterTag), t && e))
          return (e = 'string' == typeof e ? document.createTextNode(e) : e), t.appendChild(e), t.parentNode.insertBefore(e, t.nextSibling), e;
      },
      editTag: function (t, e) {
        var i = this;
        (t = t || this.getLastTag()), (e = e || {}), this.dropdown.hide.call(this);
        var s = this.settings;
        function a() {
          return t.querySelector('.' + s.classNames.tagText);
        }
        var n = a(),
          o = this.getNodeIndex(t),
          r = this.tagData(t),
          d = this.events.callbacks,
          c = this,
          h = !0;
        if (n) {
          if (!(r instanceof Object && 'editable' in r) || r.editable)
            return (
              n.setAttribute('contenteditable', !0),
              t.classList.add(s.classNames.tagEditing),
              this.tagData(t, {__originalData: l({}, r), __originalHTML: t.innerHTML}),
              n.addEventListener('focus', d.onEditTagFocus.bind(this, t)),
              n.addEventListener('blur', function () {
                setTimeout(function () {
                  return d.onEditTagBlur.call(c, a());
                });
              }),
              n.addEventListener('input', d.onEditTagInput.bind(this, n)),
              n.addEventListener('keydown', function (e) {
                return d.onEditTagkeydown.call(i, e, t);
              }),
              n.focus(),
              this.setRangeAtStartEnd(!1, n),
              e.skipValidation || (h = this.editTagToggleValidity(t, r.value)),
              (n.originalIsValid = h),
              this.trigger('edit:start', {tag: t, index: o, data: r, isValid: h}),
              this
            );
        } else console.warn('Cannot find element in Tag template: .', s.classNames.tagText);
      },
      editTagToggleValidity: function (t, e) {
        var i,
          s = this.tagData(t);
        if (s) return (i = !(!s.__isValid || 1 == s.__isValid)), t.classList.toggle(this.settings.classNames.tagInvalid, i), s.__isValid;
        console.warn('tag has no data: ', t, s);
      },
      onEditTagDone: function (t, e) {
        e = e || {};
        var i = {tag: (t = t || this.state.editing.scope), index: this.getNodeIndex(t), previousData: this.tagData(t), data: e};
        this.trigger('edit:beforeUpdate', i),
          (this.state.editing = !1),
          delete e.__originalData,
          delete e.__originalHTML,
          t && e[this.settings.tagTextProp] ? (this.editTagToggleValidity(t), this.replaceTag(t, e)) : t && this.removeTags(t),
          this.trigger('edit:updated', i),
          this.dropdown.hide.call(this),
          this.settings.keepInvalidTags && this.reCheckInvalidTags();
      },
      replaceTag: function (t, e) {
        (e && e.value) || (e = t.__tagifyTagData), e.__isValid && 1 != e.__isValid && l(e, this.getInvalidTagAttrs(e, e.__isValid));
        var i = this.createTagElem(e);
        t.parentNode.replaceChild(i, t), this.updateValueByDOMTags();
      },
      updateValueByDOMTags: function () {
        var t = this;
        (this.value.length = 0),
          [].forEach.call(this.getTagElms(), function (e) {
            e.classList.contains(t.settings.classNames.tagNotAllowed) || t.value.push(t.tagData(e));
          }),
          this.update();
      },
      setRangeAtStartEnd: function (t, e) {
        (t = 'number' == typeof t ? t : !!t), (e = (e = e || this.DOM.input).lastChild || e);
        var i = document.getSelection();
        try {
          i.rangeCount >= 1 &&
            ['Start', 'End'].forEach(function (s) {
              return i.getRangeAt(0)['set' + s](e, t || e.length);
            });
        } catch (t) {
          console.warn('Tagify: ', t);
        }
      },
      injectAtCaret: function (t, e) {
        if ((e = e || this.state.selection.range))
          return (
            'string' == typeof t && (t = document.createTextNode(t)),
            e.deleteContents(),
            e.insertNode(t),
            this.setRangeAtStartEnd(!1, t),
            this.updateValueByDOMTags(),
            this.update(),
            this
          );
      },
      input: {
        set: function () {
          var t = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : '',
            e = !(arguments.length > 1 && void 0 !== arguments[1]) || arguments[1],
            i = this.settings.dropdown.closeOnSelect;
          (this.state.inputText = t),
            e && (this.DOM.input.innerHTML = t),
            !t && i && this.dropdown.hide.bind(this),
            this.input.autocomplete.suggest.call(this),
            this.input.validate.call(this);
        },
        validate: function () {
          var t = !this.state.inputText || !0 === this.validateTag({value: this.state.inputText});
          return this.DOM.input.classList.toggle(this.settings.classNames.inputInvalid, !t), t;
        },
        normalize: function (t) {
          var e = t || this.DOM.input,
            i = [];
          e.childNodes.forEach(function (t) {
            return 3 == t.nodeType && i.push(t.nodeValue);
          }),
            (i = i.join('\n'));
          try {
            i = i.replace(/(?:\r\n|\r|\n)/g, this.settings.delimiters.source.charAt(0));
          } catch (t) {}
          return (i = i.replace(/\s/g, ' ')), this.settings.trim && (i = i.replace(/^\s+/, '')), i;
        },
        autocomplete: {
          suggest: function (t) {
            if (this.settings.autoComplete.enabled) {
              'string' == typeof (t = t || {}) && (t = {value: t});
              var e = t.value ? '' + t.value : '',
                i = e.substr(0, this.state.inputText.length).toLowerCase(),
                s = e.substring(this.state.inputText.length);
              e && this.state.inputText && i == this.state.inputText.toLowerCase()
                ? (this.DOM.input.setAttribute('data-suggest', s), (this.state.inputSuggestion = t))
                : (this.DOM.input.removeAttribute('data-suggest'), delete this.state.inputSuggestion);
            }
          },
          set: function (t) {
            var e = this.DOM.input.getAttribute('data-suggest'),
              i = t || (e ? this.state.inputText + e : null);
            return (
              !!i &&
              ('mix' == this.settings.mode
                ? this.replaceTextWithNode(document.createTextNode(this.state.tag.prefix + i))
                : (this.input.set.call(this, i), this.setRangeAtStartEnd()),
              this.input.autocomplete.suggest.call(this),
              this.dropdown.hide.call(this),
              !0)
            );
          },
        },
      },
      getTagIdx: function (t) {
        return this.value.findIndex(function (e) {
          return e.value == t.value;
        });
      },
      getNodeIndex: function (t) {
        var e = 0;
        if (t) for (; (t = t.previousElementSibling); ) e++;
        return e;
      },
      getTagElms: function () {
        for (var t = arguments.length, e = new Array(t), i = 0; i < t; i++) e[i] = arguments[i];
        var s = ['.' + this.settings.classNames.tag].concat(e).join('.');
        return [].slice.call(this.DOM.scope.querySelectorAll(s));
      },
      getLastTag: function () {
        var t = this.DOM.scope.querySelectorAll(
          '.'.concat(this.settings.classNames.tag, ':not(.').concat(this.settings.classNames.tagHide, '):not([readonly])'),
        );
        return t[t.length - 1];
      },
      tagData: function (t, e, i) {
        return t
          ? (e && (t.__tagifyTagData = i ? e : l({}, t.__tagifyTagData || {}, e)), t.__tagifyTagData)
          : (console.warn("tag elment doesn't exist", t, e), e);
      },
      isTagDuplicate: function (t, e) {
        var i = this,
          a = this.settings;
        return (
          'select' != a.mode &&
          this.value.reduce(function (n, o) {
            return s(i.trim('' + t), o.value, e || a.dropdown.caseSensitive) ? n + 1 : n;
          }, 0)
        );
      },
      getTagIndexByValue: function (t) {
        var e = this,
          i = [];
        return (
          this.getTagElms().forEach(function (a, n) {
            s(e.trim(a.textContent), t, e.settings.dropdown.caseSensitive) && i.push(n);
          }),
          i
        );
      },
      getTagElmByValue: function (t) {
        var e = this.getTagIndexByValue(t)[0];
        return this.getTagElms()[e];
      },
      flashTag: function (t) {
        var e = this;
        t &&
          (t.classList.add(this.settings.classNames.tagFlash),
          setTimeout(function () {
            t.classList.remove(e.settings.classNames.tagFlash);
          }, 100));
      },
      isTagBlacklisted: function (t) {
        return (
          (t = this.trim(t.toLowerCase())),
          this.settings.blacklist.filter(function (e) {
            return ('' + e).toLowerCase() == t;
          }).length
        );
      },
      isTagWhitelisted: function (t) {
        return !!this.getWhitelistItem(t);
      },
      getWhitelistItem: function (t, e, i) {
        e = e || 'value';
        var a,
          n = this.settings,
          o = ((i = i || n.whitelist), n.dropdown.caseSensitive);
        return (
          i.some(function (i) {
            var n = 'string' == typeof i ? i : i[e];
            if (s(n, t, o)) return (a = 'string' == typeof i ? {value: i} : i), !0;
          }),
          a || 'value' != e || 'value' == n.tagTextProp || (a = this.getWhitelistItem(t, n.tagTextProp, i)),
          a
        );
      },
      validateTag: function (t) {
        var e = this.settings,
          i = 'value' in t ? 'value' : e.tagTextProp,
          s = this.trim(t[i] + '');
        return (t[i] + '').trim()
          ? e.pattern && e.pattern instanceof RegExp && !e.pattern.test(s)
            ? this.TEXTS.pattern
            : !e.duplicates && this.isTagDuplicate(s, this.state.editing)
            ? this.TEXTS.duplicate
            : !(this.isTagBlacklisted(s) || (e.enforceWhitelist && !this.isTagWhitelisted(s))) || this.TEXTS.notAllowed
          : this.TEXTS.empty;
      },
      getInvalidTagAttrs: function (t, e) {
        return {
          'aria-invalid': !0,
          class: ''
            .concat(t.class || '', ' ')
            .concat(this.settings.classNames.tagNotAllowed)
            .trim(),
          title: e,
        };
      },
      hasMaxTags: function () {
        return this.value.length >= this.settings.maxTags && this.TEXTS.exceed;
      },
      setReadonly: function (t) {
        var e = this.settings;
        document.activeElement.blur(),
          (e.readonly = t),
          this.DOM.scope[(t ? 'set' : 'remove') + 'Attribute']('readonly', !0),
          'mix' == e.mode && (this.DOM.input.contentEditable = !t);
      },
      normalizeTags: function (t) {
        var s = this,
          a = this.settings,
          n = a.whitelist,
          o = a.delimiters,
          r = a.mode,
          l = a.tagTextProp,
          d = a.enforceWhitelist,
          c = [],
          h = !!n && n[0] instanceof Object,
          g = t instanceof Array,
          u = function (t) {
            return (t + '')
              .split(o)
              .filter(function (t) {
                return t;
              })
              .map(function (t) {
                return e({}, l, s.trim(t));
              });
          };
        if (('number' == typeof t && (t = t.toString()), 'string' == typeof t)) {
          if (!t.trim()) return [];
          t = u(t);
        } else if (g) {
          var p;
          t = (p = []).concat.apply(
            p,
            i(
              t.map(function (t) {
                return t.value ? t : u(t);
              }),
            ),
          );
        }
        return (
          h &&
            (t.forEach(function (t) {
              var e = c.map(function (t) {
                  return t.value;
                }),
                i = s.dropdown.filterListItems.call(s, t[l], {exact: !0}).filter(function (t) {
                  return !e.includes(t.value);
                }),
                a = i.length > 1 ? s.getWhitelistItem(t[l], l, i) : i[0];
              a && a instanceof Object ? c.push(a) : 'mix' == r || d || (null == t.value && (t.value = t[l]), c.push(t));
            }),
            (t = c)),
          t
        );
      },
      parseMixTags: function (t) {
        var e = this,
          i = this.settings,
          s = i.mixTagsInterpolator,
          a = i.duplicates,
          n = i.transformTag,
          o = i.enforceWhitelist,
          r = i.maxTags,
          l = i.tagTextProp,
          d = [];
        return (
          (t = t
            .split(s[0])
            .map(function (t, i) {
              var c,
                h,
                g,
                u = t.split(s[1]),
                p = u[0],
                f = d.length == r;
              try {
                if (p == +p) throw Error;
                h = JSON.parse(p);
              } catch (t) {
                h = e.normalizeTags(p)[0] || {value: p};
              }
              if (f || !(u.length > 1) || (o && !e.isTagWhitelisted(h.value)) || (!a && e.isTagDuplicate(h.value))) {
                if (t) return i ? s[0] + t : t;
              } else n.call(e, h), (h[(c = h[l] ? l : 'value')] = e.trim(h[c])), (g = e.createTagElem(h)), d.push(h), g.classList.add(e.settings.classNames.tagNoAnimation), (u[0] = g.outerHTML), e.value.push(h);
              return u.join('');
            })
            .join('')),
          (this.DOM.input.innerHTML = t),
          this.DOM.input.appendChild(document.createTextNode('')),
          this.DOM.input.normalize(),
          this.getTagElms().forEach(function (t, i) {
            return e.tagData(t, d[i]);
          }),
          this.update({withoutChangeEvent: !0}),
          t
        );
      },
      replaceTextWithNode: function (t, e) {
        if (this.state.tag || e) {
          e = e || this.state.tag.prefix + this.state.tag.value;
          var i,
            s,
            a = window.getSelection(),
            n = a.anchorNode,
            o = this.state.tag.delimiters ? this.state.tag.delimiters.length : 0;
          return n.splitText(a.anchorOffset - o), (i = n.nodeValue.lastIndexOf(e)), (s = n.splitText(i)), t && n.parentNode.replaceChild(t, s), !0;
        }
      },
      selectTag: function (t, e) {
        if (!this.settings.enforceWhitelist || this.isTagWhitelisted(e.value))
          return (
            this.input.set.call(this, e.value, !0),
            this.state.actions.selectOption && setTimeout(this.setRangeAtStartEnd.bind(this)),
            this.getLastTag() ? this.replaceTag(this.getLastTag(), e) : this.appendTag(t),
            (this.value[0] = e),
            this.trigger('add', {tag: t, data: e}),
            this.update(),
            [t]
          );
      },
      addEmptyTag: function (t) {
        var e = l({value: ''}, t || {}),
          i = this.createTagElem(e);
        this.tagData(i, e), this.appendTag(i), this.editTag(i, {skipValidation: !0});
      },
      addTags: function (t, e) {
        var i = this,
          s = arguments.length > 2 && void 0 !== arguments[2] ? arguments[2] : this.settings.skipInvalid,
          a = [],
          n = this.settings;
        return t && 0 != t.length
          ? ((t = this.normalizeTags(t)),
            'mix' == n.mode
              ? this.addMixTags(t)
              : ('select' == n.mode && (e = !1),
                this.DOM.input.removeAttribute('style'),
                t.forEach(function (t) {
                  var e,
                    o = {},
                    r = Object.assign({}, t, {value: t.value + ''});
                  if ((((t = Object.assign({}, r)).__isValid = i.hasMaxTags() || i.validateTag(t)), n.transformTag.call(i, t), !0 !== t.__isValid)) {
                    if (s) return;
                    l(o, i.getInvalidTagAttrs(t, t.__isValid), {__preInvalidData: r}),
                      t.__isValid == i.TEXTS.duplicate && i.flashTag(i.getTagElmByValue(t.value));
                  }
                  if ((t.readonly && (o['aria-readonly'] = !0), (e = i.createTagElem(l({}, t, o))), a.push(e), 'select' == n.mode)) return i.selectTag(e, t);
                  i.appendTag(e),
                    t.__isValid && !0 === t.__isValid
                      ? (i.value.push(t), i.update(), i.trigger('add', {tag: e, index: i.value.length - 1, data: t}))
                      : (i.trigger('invalid', {data: t, index: i.value.length, tag: e, message: t.__isValid}),
                        n.keepInvalidTags ||
                          setTimeout(function () {
                            return i.removeTags(e, !0);
                          }, 1e3)),
                    i.dropdown.position.call(i);
                }),
                t.length && e && this.input.set.call(this),
                this.dropdown.refilter.call(this),
                a))
          : ('select' == n.mode && this.removeAllTags(), a);
      },
      addMixTags: function (t) {
        var e,
          i = this,
          s = this.settings,
          a = this.state.tag.delimiters;
        return (
          s.transformTag.call(this, t[0]),
          (t[0].prefix = t[0].prefix || this.state.tag ? this.state.tag.prefix : (s.pattern.source || s.pattern)[0]),
          (e = this.createTagElem(t[0])),
          this.replaceTextWithNode(e) || this.DOM.input.appendChild(e),
          setTimeout(function () {
            return e.classList.add(i.settings.classNames.tagNoAnimation);
          }, 300),
          this.value.push(t[0]),
          this.update(),
          !a &&
            setTimeout(
              function () {
                var t = i.insertAfterTag(e) || e;
                i.placeCaretAfterNode(t);
              },
              this.isFirefox ? 100 : 0,
            ),
          (this.state.tag = null),
          this.trigger('add', l({}, {tag: e}, {data: t[0]})),
          e
        );
      },
      appendTag: function (t) {
        var e = this.DOM.scope.lastElementChild;
        e === this.DOM.input ? this.DOM.scope.insertBefore(t, e) : this.DOM.scope.appendChild(t);
      },
      createTagElem: function (t) {
        var e,
          i = l({}, t, {value: n(t.value + '')});
        return (
          this.settings.readonly && (t.readonly = !0),
          (function (t) {
            for (var e, i = document.createNodeIterator(t, NodeFilter.SHOW_TEXT, null, !1); (e = i.nextNode()); )
              e.textContent.trim() || e.parentNode.removeChild(e);
          })((e = this.parseTemplate('tag', [i]))),
          this.tagData(e, t),
          e
        );
      },
      reCheckInvalidTags: function () {
        var t = this,
          e = this.settings,
          i = '.'.concat(e.classNames.tag, '.').concat(e.classNames.tagNotAllowed),
          s = this.DOM.scope.querySelectorAll(i);
        [].forEach.call(s, function (e) {
          var i = t.tagData(e),
            s = e.getAttribute('title') == t.TEXTS.duplicate,
            a = !0 === t.validateTag(i);
          s && a && ((i = i.__preInvalidData ? i.__preInvalidData : {value: i.value}), t.replaceTag(e, i));
        });
      },
      removeTags: function (t, e, i) {
        var s,
          a = this;
        (t = t && t instanceof HTMLElement ? [t] : t instanceof Array ? t : t ? [t] : [this.getLastTag()]),
          (s = t.reduce(function (t, e) {
            return (
              e && 'string' == typeof e && (e = a.getTagElmByValue(e)),
              e && t.push({node: e, idx: a.getTagIdx(a.tagData(e)), data: a.tagData(e, {__removed: !0})}),
              t
            );
          }, [])),
          (i = 'number' == typeof i ? i : this.CSSVars.tagHideTransition),
          'select' == this.settings.mode && ((i = 0), this.input.set.call(this)),
          1 == s.length && s[0].node.classList.contains(this.settings.classNames.tagNotAllowed) && (e = !0),
          s.length &&
            this.settings.hooks
              .beforeRemoveTag(s, {tagify: this})
              .then(function () {
                function t(t) {
                  t.node.parentNode &&
                    (t.node.parentNode.removeChild(t.node),
                    e
                      ? this.settings.keepInvalidTags && this.trigger('remove', {tag: t.node, index: t.idx})
                      : (this.trigger('remove', {tag: t.node, index: t.idx, data: t.data}),
                        this.dropdown.refilter.call(this),
                        this.dropdown.position.call(this),
                        this.DOM.input.normalize(),
                        this.settings.keepInvalidTags && this.reCheckInvalidTags()));
                }
                i && i > 10 && 1 == s.length
                  ? function (e) {
                      (e.node.style.width = parseFloat(window.getComputedStyle(e.node).width) + 'px'),
                        document.body.clientTop,
                        e.node.classList.add(this.settings.classNames.tagHide),
                        setTimeout(t.bind(this), i, e);
                    }.call(a, s[0])
                  : s.forEach(t.bind(a)),
                  e ||
                    (s.forEach(function (t) {
                      var e = Object.assign({}, t.data);
                      delete e.__removed;
                      var i = a.getTagIdx(e);
                      i > -1 && a.value.splice(i, 1);
                    }),
                    a.update());
              })
              .catch(function (t) {});
      },
      removeAllTags: function () {
        (this.value = []),
          'mix' == this.settings.mode
            ? (this.DOM.input.innerHTML = '')
            : Array.prototype.slice.call(this.getTagElms()).forEach(function (t) {
                return t.parentNode.removeChild(t);
              }),
          this.dropdown.position.call(this),
          'select' == this.settings.mode && this.input.set.call(this),
          this.update();
      },
      postUpdate: function () {
        var t = this.settings.classNames,
          e = 'mix' == this.settings.mode ? (this.settings.mixMode.integrated ? this.DOM.input.textContent : this.DOM.originalInput.value) : this.value.length;
        this.toggleClass(t.hasMaxTags, this.value.length >= this.settings.maxTags),
          this.toggleClass(t.hasNoTags, !this.value.length),
          this.toggleClass(t.empty, !e);
      },
      update: function (t) {
        var e,
          i,
          s = this.DOM.originalInput,
          a = (t || {}).withoutChangeEvent,
          n =
            ((e = this.value),
            (i = ['__isValid', '__removed']),
            e.map(function (t) {
              var e = {};
              for (var s in t) i.indexOf(s) < 0 && (e[s] = t[s]);
              return e;
            }));
        this.settings.mixMode.integrated ||
          (s.value =
            'mix' == this.settings.mode
              ? this.getMixedTagsAsString(n)
              : n.length
              ? this.settings.originalInputValueFormat
                ? this.settings.originalInputValueFormat(n)
                : JSON.stringify(n)
              : ''),
          this.postUpdate(),
          !a && this.state.loadedOriginalValues && this.triggerChangeEvent();
      },
      getMixedTagsAsString: function () {
        var t = '',
          e = this,
          i = this.settings.mixTagsInterpolator;
        return (
          (function s(a) {
            a.childNodes.forEach(function (a) {
              if (1 == a.nodeType) {
                if (a.classList.contains(e.settings.classNames.tag) && e.tagData(a)) {
                  if (e.tagData(a).__removed) return;
                  return void (t += i[0] + JSON.stringify(a.__tagifyTagData) + i[1]);
                }
                'BR' != a.tagName || (a.parentNode != e.DOM.input && 1 != a.parentNode.childNodes.length)
                  ? ('DIV' != a.tagName && 'P' != a.tagName) || ((t += '\r\n'), s(a))
                  : (t += '\r\n');
              } else t += a.textContent;
            });
          })(this.DOM.input),
          t
        );
      },
    }),
    (u.prototype.removeTag = u.prototype.removeTags),
    u
  );
});
