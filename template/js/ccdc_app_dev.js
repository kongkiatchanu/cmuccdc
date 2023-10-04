Object.assign ||
    Object.defineProperty(Object, "assign", {
        enumerable: !1,
        configurable: !0,
        writable: !0,
        value: function (t) {
            "use strict";
            if (null == t) throw new TypeError("Cannot convert first argument to object");
            for (var e = Object(t), i = 1; i < arguments.length; i++) {
                var s = arguments[i];
                if (null != s) {
                    s = Object(s);
                    for (var o = Object.keys(Object(s)), n = 0, a = o.length; n < a; n++) {
                        var r = o[n],
                            l = Object.getOwnPropertyDescriptor(s, r);
                        void 0 !== l && l.enumerable && (e[r] = s[r]);
                    }
                }
            }
            return e;
        },
    }),
    String.prototype.endsWith ||
        (String.prototype.endsWith = function (t, e) {
            return (void 0 === e || e > this.length) && (e = this.length), this.substring(e - t.length, e) === t;
        }),
    (function (t) {
        function e(t, e) {
            var i,
                s = e || !1,
                o = [2, 3, 4, 5, 7, 8, 9],
                n = [0, 0, 0, 0, 0, 0, 0],
                a = [0, 12, 4, 7, 24, 60, 60];
            if (!(t = t.toUpperCase())) return n;
            if ("string" != typeof t) throw Error("Invalid iso8601 period string '" + t + "'");
            if (!(i = /^P((\d+Y)?(\d+M)?(\d+W)?(\d+D)?)?(T(\d+H)?(\d+M)?(\d+S)?)?$/.exec(t))) throw Error("String '" + t + "' is not a valid ISO8601 period.");
            for (var r = 0; r < o.length; r++) {
                var l = o[r];
                n[r] = i[l] ? +i[l].replace(/[A-Za-z]+/g, "") : 0;
            }
            if (s) for (r = n.length - 1; 0 < r; r--) n[r] >= a[r] && ((n[r - 1] += Math.floor(n[r] / a[r])), (n[r] %= a[r]));
            return n;
        }
        t.iso8601 || (t.iso8601 = {}),
            t.iso8601.Period || (t.iso8601.Period = {}),
            (t.iso8601.version = "0.2"),
            (t.iso8601.Period.parse = function (t, i) {
                return e(t, i);
            }),
            (t.iso8601.Period.parseToTotalSeconds = function (t) {
                var i = [31104e3, 2592e3, 604800, 86400, 3600, 60, 1];
                t = e(t);
                for (var s = 0, o = 0; o < t.length; o++) s += t[o] * i[o];
                return s;
            }),
            (t.iso8601.Period.isValid = function (t) {
                try {
                    return e(t), !0;
                } catch (t) {
                    return !1;
                }
            }),
            (t.iso8601.Period.parseToString = function (t, i, s, o) {
                var n = "      ".split(" ");
                for (t = e(t, o), i || (i = "year month week day hour minute second".split(" ")), s || (s = "years months weeks days hours minutes seconds".split(" ")), o = 0; o < t.length; o++)
                    0 < t[o] && (n[o] = 1 == t[o] ? t[o] + " " + i[o] : t[o] + " " + s[o]);
                return n
                    .join(" ")
                    .trim()
                    .replace(/[ ]{2,}/g, " ");
            });
    })((window.nezasa = window.nezasa || {})),
    (L.TimeDimension = (L.Layer || L.Class).extend({
        includes: L.Evented || L.Mixin.Events,
        initialize: function (t) {
            L.setOptions(this, t),
                (this._availableTimes = this._generateAvailableTimes()),
                (this._currentTimeIndex = -1),
                (this._loadingTimeIndex = -1),
                (this._loadingTimeout = this.options.loadingTimeout || 3e3),
                (this._syncedLayers = []),
                this._availableTimes.length > 0 && this.setCurrentTime(this.options.currentTime || this._getDefaultCurrentTime()),
                this.options.lowerLimitTime && this.setLowerLimit(this.options.lowerLimitTime),
                this.options.upperLimitTime && this.setUpperLimit(this.options.upperLimitTime);
        },
        getAvailableTimes: function () {
            return this._availableTimes;
        },
        getCurrentTimeIndex: function () {
            return -1 === this._currentTimeIndex ? this._availableTimes.length - 1 : this._currentTimeIndex;
        },
        getCurrentTime: function () {
            var t;
            return (t = -1 !== this._loadingTimeIndex ? this._loadingTimeIndex : this.getCurrentTimeIndex()) >= 0 ? this._availableTimes[t] : null;
        },
        isLoading: function () {
            return -1 !== this._loadingTimeIndex;
        },
        setCurrentTimeIndex: function (t) {
            var e = this._upperLimit || this._availableTimes.length - 1,
                i = this._lowerLimit || 0;
            if (!((t = Math.min(Math.max(i, t), e)) < 0)) {
                this._loadingTimeIndex = t;
                var s = this._availableTimes[t];
                this._checkSyncedLayersReady(this._availableTimes[this._loadingTimeIndex])
                    ? this._newTimeIndexLoaded()
                    : (this.fire("timeloading", { time: s }),
                      setTimeout(
                          function (t) {
                              t == this._loadingTimeIndex && this._newTimeIndexLoaded();
                          }.bind(this, t),
                          this._loadingTimeout
                      ));
            }
        },
        _newTimeIndexLoaded: function () {
            if (-1 !== this._loadingTimeIndex) {
                var t = this._availableTimes[this._loadingTimeIndex];
                (this._currentTimeIndex = this._loadingTimeIndex), this.fire("timeload", { time: t }), (this._loadingTimeIndex = -1);
            }
        },
        _checkSyncedLayersReady: function (t) {
            for (var e = 0, i = this._syncedLayers.length; e < i; e++) if (this._syncedLayers[e].isReady && !this._syncedLayers[e].isReady(t)) return !1;
            return !0;
        },
        setCurrentTime: function (t) {
            var e = this._seekNearestTimeIndex(t);
            this.setCurrentTimeIndex(e);
        },
        seekNearestTime: function (t) {
            var e = this._seekNearestTimeIndex(t);
            return this._availableTimes[e];
        },
        nextTime: function (t, e) {
            t || (t = 1);
            var i = this._currentTimeIndex,
                s = this._upperLimit || this._availableTimes.length - 1,
                o = this._lowerLimit || 0;
            this._loadingTimeIndex > -1 && (i = this._loadingTimeIndex), (i += t) > s && (i = e ? o : s), i < o && (i = e ? s : o), this.setCurrentTimeIndex(i);
        },
        prepareNextTimes: function (t, e, i) {
            t || (t = 1);
            var s = this._currentTimeIndex,
                o = s;
            this._loadingTimeIndex > -1 && (s = this._loadingTimeIndex);
            for (var n = 0, a = this._syncedLayers.length; n < a; n++) this._syncedLayers[n].setMinimumForwardCache && this._syncedLayers[n].setMinimumForwardCache(e);
            for (var r = e, l = this._upperLimit || this._availableTimes.length - 1, h = this._lowerLimit || 0; r > 0; ) {
                if ((s += t) > l) {
                    if (!i) break;
                    s = h;
                }
                if (s < h) {
                    if (!i) break;
                    s = l;
                }
                if (o === s) break;
                this.fire("timeloading", { time: this._availableTimes[s] }), r--;
            }
        },
        getNumberNextTimesReady: function (t, e, i) {
            t || (t = 1);
            var s = this._currentTimeIndex;
            this._loadingTimeIndex > -1 && (s = this._loadingTimeIndex);
            for (var o = e, n = 0, a = this._upperLimit || this._availableTimes.length - 1, r = this._lowerLimit || 0; o > 0; ) {
                if ((s += t) > a) {
                    if (!i) {
                        (o = 0), (n = e);
                        break;
                    }
                    s = r;
                }
                if (s < r) {
                    if (!i) {
                        (o = 0), (n = e);
                        break;
                    }
                    s = a;
                }
                var l = this._availableTimes[s];
                this._checkSyncedLayersReady(l) && n++, o--;
            }
            return n;
        },
        previousTime: function (t, e) {
            this.nextTime(-1 * t, e);
        },
        registerSyncedLayer: function (t) {
            this._syncedLayers.push(t), t.on("timeload", this._onSyncedLayerLoaded, this);
        },
        unregisterSyncedLayer: function (t) {
            var e = this._syncedLayers.indexOf(t);
            -1 != e && this._syncedLayers.splice(e, 1), t.off("timeload", this._onSyncedLayerLoaded, this);
        },
        _onSyncedLayerLoaded: function (t) {
            t.time == this._availableTimes[this._loadingTimeIndex] && this._checkSyncedLayersReady(t.time) && this._newTimeIndexLoaded();
        },
        _generateAvailableTimes: function () {
            if (this.options.times) return L.TimeDimension.Util.parseTimesExpression(this.options.times);
            if (this.options.timeInterval) {
                var t = L.TimeDimension.Util.parseTimeInterval(this.options.timeInterval),
                    e = this.options.period || "P1D",
                    i = this.options.validTimeRange || void 0;
                return L.TimeDimension.Util.explodeTimeRange(t[0], t[1], e, i);
            }
            return [];
        },
        _getDefaultCurrentTime: function () {
            var t = this._seekNearestTimeIndex(new Date().getTime());
            return this._availableTimes[t];
        },
        _seekNearestTimeIndex: function (t) {
            for (var e = 0, i = this._availableTimes.length; e < i && !(t < this._availableTimes[e]); e++);
            return e > 0 && e--, e;
        },
        setAvailableTimes: function (t, e) {
            var i = this.getCurrentTime(),
                s = this.getLowerLimit(),
                o = this.getUpperLimit();
            if ("extremes" == e) {
                var n = this.options.period || "P1D";
                this._availableTimes = L.TimeDimension.Util.explodeTimeRange(new Date(t[0]), new Date(t[t.length - 1]), n);
            } else {
                var a = L.TimeDimension.Util.parseTimesExpression(t);
                if (0 === this._availableTimes.length) this._availableTimes = a;
                else if ("intersect" == e) this._availableTimes = L.TimeDimension.Util.intersect_arrays(a, this._availableTimes);
                else if ("union" == e) this._availableTimes = L.TimeDimension.Util.union_arrays(a, this._availableTimes);
                else {
                    if ("replace" != e) throw "Merge available times mode not implemented: " + e;
                    this._availableTimes = a;
                }
            }
            s && this.setLowerLimit(s), o && this.setUpperLimit(o), this.setCurrentTime(i), this.fire("availabletimeschanged", { availableTimes: this._availableTimes, currentTime: i });
        },
        getLowerLimit: function () {
            return this._availableTimes[this.getLowerLimitIndex()];
        },
        getUpperLimit: function () {
            return this._availableTimes[this.getUpperLimitIndex()];
        },
        setLowerLimit: function (t) {
            var e = this._seekNearestTimeIndex(t);
            this.setLowerLimitIndex(e);
        },
        setUpperLimit: function (t) {
            var e = this._seekNearestTimeIndex(t);
            this.setUpperLimitIndex(e);
        },
        setLowerLimitIndex: function (t) {
            (this._lowerLimit = Math.min(Math.max(t || 0, 0), this._upperLimit || this._availableTimes.length - 1)), this.fire("limitschanged", { lowerLimit: this._lowerLimit, upperLimit: this._upperLimit });
        },
        setUpperLimitIndex: function (t) {
            (this._upperLimit = Math.max(Math.min(t, this._availableTimes.length - 1), this._lowerLimit || 0)), this.fire("limitschanged", { lowerLimit: this._lowerLimit, upperLimit: this._upperLimit });
        },
        getLowerLimitIndex: function () {
            return this._lowerLimit;
        },
        getUpperLimitIndex: function () {
            return this._upperLimit;
        },
    })),
    L.Map.addInitHook(function () {
        this.options.timeDimension && (this.timeDimension = L.timeDimension(this.options.timeDimensionOptions || {}));
    }),
    (L.timeDimension = function (t) {
        return new L.TimeDimension(t);
    }),
    (L.TimeDimension.Util = {
        getTimeDuration: function (t) {
            if ("undefined" == typeof nezasa) throw "iso8601-js-period library is required for Leatlet.TimeDimension: https://github.com/nezasa/iso8601-js-period";
            return nezasa.iso8601.Period.parse(t, !0);
        },
        addTimeDuration: function (t, e, i) {
            void 0 === i && (i = !0), ("string" == typeof e || e instanceof String) && (e = this.getTimeDuration(e));
            var s = e.length,
                o = i ? "getUTC" : "get",
                n = i ? "setUTC" : "set";
            s > 0 && 0 != e[0] && t[n + "FullYear"](t[o + "FullYear"]() + e[0]),
                s > 1 && 0 != e[1] && t[n + "Month"](t[o + "Month"]() + e[1]),
                s > 2 && 0 != e[2] && t[n + "Date"](t[o + "Date"]() + 7 * e[2]),
                s > 3 && 0 != e[3] && t[n + "Date"](t[o + "Date"]() + e[3]),
                s > 4 && 0 != e[4] && t[n + "Hours"](t[o + "Hours"]() + e[4]),
                s > 5 && 0 != e[5] && t[n + "Minutes"](t[o + "Minutes"]() + e[5]),
                s > 6 && 0 != e[6] && t[n + "Seconds"](t[o + "Seconds"]() + e[6]);
        },
        subtractTimeDuration: function (t, e, i) {
            ("string" == typeof e || e instanceof String) && (e = this.getTimeDuration(e));
            for (var s = [], o = 0, n = e.length; o < n; o++) s.push(-e[o]);
            this.addTimeDuration(t, s, i);
        },
        parseAndExplodeTimeRange: function (t) {
            var e = t.split("/"),
                i = new Date(Date.parse(e[0])),
                s = new Date(Date.parse(e[1])),
                o = e.length > 2 ? e[2] : "P1D";
            return this.explodeTimeRange(i, s, o);
        },
        explodeTimeRange: function (t, e, i, s) {
            var o = this.getTimeDuration(i),
                n = [],
                a = new Date(t.getTime()),
                r = null,
                l = null,
                h = null,
                c = null;
            if (void 0 !== s) {
                var p = s.split("/");
                (r = p[0].split(":")[0]), (l = p[0].split(":")[1]), (h = p[1].split(":")[0]), (c = p[1].split(":")[1]);
            }
            for (; a < e; )
                (void 0 === s || (a.getUTCHours() >= r && a.getUTCHours() <= h)) && (a.getUTCHours() != r || a.getUTCMinutes() >= l) && (a.getUTCHours() != h || a.getUTCMinutes() <= c) && n.push(a.getTime()), this.addTimeDuration(a, o);
            return a >= e && n.push(e.getTime()), n;
        },
        parseTimeInterval: function (t) {
            var e = t.split("/");
            if (2 != e.length) throw "Incorrect ISO9601 TimeInterval: " + t;
            var i = Date.parse(e[0]),
                s = null,
                o = null;
            return (
                isNaN(i)
                    ? ((o = this.getTimeDuration(e[0])), (s = Date.parse(e[1])), (i = new Date(s)), this.subtractTimeDuration(i, o, !0), (s = new Date(s)))
                    : ((s = Date.parse(e[1])), isNaN(s) ? ((o = this.getTimeDuration(e[1])), (s = new Date(i)), this.addTimeDuration(s, o, !0)) : (s = new Date(s)), (i = new Date(i))),
                [i, s]
            );
        },
        parseTimesExpression: function (t) {
            var e = [];
            if (!t) return e;
            if ("string" == typeof t || t instanceof String)
                for (var i, s, o = t.split(","), n = 0, a = o.length; n < a; n++) 3 == (i = o[n]).split("/").length ? (e = e.concat(this.parseAndExplodeTimeRange(i))) : ((s = Date.parse(i)), isNaN(s) || e.push(s));
            else e = t;
            return e.sort(function (t, e) {
                return t - e;
            });
        },
        intersect_arrays: function (t, e) {
            for (var i = t.slice(0), s = e.slice(0), o = []; i.length > 0 && s.length > 0; ) i[0] < s[0] ? i.shift() : i[0] > s[0] ? s.shift() : (o.push(i.shift()), s.shift());
            return o;
        },
        union_arrays: function (t, e) {
            for (var i = t.slice(0), s = e.slice(0), o = []; i.length > 0 && s.length > 0; ) i[0] < s[0] ? o.push(i.shift()) : i[0] > s[0] ? o.push(s.shift()) : (o.push(i.shift()), s.shift());
            return i.length > 0 ? (o = o.concat(i)) : s.length > 0 && (o = o.concat(s)), o;
        },
    }),
    (L.TimeDimension.Player = (L.Layer || L.Class).extend({
        includes: L.Evented || L.Mixin.Events,
        initialize: function (t, e) {
            L.setOptions(this, t),
                (this._timeDimension = e),
                (this._paused = !1),
                (this._buffer = this.options.buffer || 5),
                (this._minBufferReady = this.options.minBufferReady || 1),
                (this._waitingForBuffer = !1),
                (this._loop = this.options.loop || !1),
                (this._steps = 1),
                this._timeDimension.on(
                    "timeload",
                    function (t) {
                        this.release(), (this._waitingForBuffer = !1);
                    }.bind(this)
                ),
                this.setTransitionTime(this.options.transitionTime || 1e3),
                this._timeDimension.on(
                    "limitschanged availabletimeschanged timeload",
                    function (t) {
                        this._timeDimension.prepareNextTimes(this._steps, this._minBufferReady, this._loop);
                    }.bind(this)
                );
        },
        _tick: function () {
            var t = this._getMaxIndex(),
                e = this._timeDimension.getCurrentTimeIndex() >= t && this._steps > 0,
                i = 0 == this._timeDimension.getCurrentTimeIndex() && this._steps < 0;
            if ((e || i) && !this._loop) return this.pause(), this.stop(), void this.fire("animationfinished");
            if (!this._paused) {
                var s = 0,
                    o = this._bufferSize;
                if (this._minBufferReady > 0)
                    if (((s = this._timeDimension.getNumberNextTimesReady(this._steps, o, this._loop)), this._waitingForBuffer)) {
                        if (s < o) return void this.fire("waiting", { buffer: o, available: s });
                        this.fire("running"), (this._waitingForBuffer = !1);
                    } else if (s < this._minBufferReady) return (this._waitingForBuffer = !0), this._timeDimension.prepareNextTimes(this._steps, o, this._loop), void this.fire("waiting", { buffer: o, available: s });
                this.pause(), this._timeDimension.nextTime(this._steps, this._loop), o > 0 && this._timeDimension.prepareNextTimes(this._steps, o, this._loop);
            }
        },
        _getMaxIndex: function () {
            return Math.min(this._timeDimension.getAvailableTimes().length - 1, this._timeDimension.getUpperLimitIndex() || 1 / 0);
        },
        start: function (t) {
            this._intervalID ||
                ((this._steps = t || 1),
                (this._waitingForBuffer = !1),
                this.options.startOver && this._timeDimension.getCurrentTimeIndex() === this._getMaxIndex() && this._timeDimension.setCurrentTimeIndex(this._timeDimension.getLowerLimitIndex() || 0),
                this.release(),
                (this._intervalID = window.setInterval(L.bind(this._tick, this), this._transitionTime)),
                this._tick(),
                this.fire("play"),
                this.fire("running"));
        },
        stop: function () {
            this._intervalID && (clearInterval(this._intervalID), (this._intervalID = null), (this._waitingForBuffer = !1), this.fire("stop"));
        },
        pause: function () {
            this._paused = !0;
        },
        release: function () {
            this._paused = !1;
        },
        getTransitionTime: function () {
            return this._transitionTime;
        },
        isPlaying: function () {
            return !!this._intervalID;
        },
        isWaiting: function () {
            return this._waitingForBuffer;
        },
        isLooped: function () {
            return this._loop;
        },
        setLooped: function (t) {
            (this._loop = t), this.fire("loopchange", { loop: t });
        },
        setTransitionTime: function (t) {
            (this._transitionTime = t),
                "function" == typeof this._buffer ? (this._bufferSize = this._buffer.call(this, this._transitionTime, this._minBufferReady, this._loop)) : (this._bufferSize = this._buffer),
                this._intervalID && (this.stop(), this.start(this._steps)),
                this.fire("speedchange", { transitionTime: t, buffer: this._bufferSize });
        },
        getSteps: function () {
            return this._steps;
        },
    })),
    (L.UI = L.ui = L.UI || {}),
    (L.UI.Knob = L.Draggable.extend({
        options: { className: "knob", step: 1, rangeMin: 0, rangeMax: 10 },
        initialize: function (t, e) {
            L.setOptions(this, e),
                (this._element = L.DomUtil.create("div", this.options.className || "knob", t)),
                L.Draggable.prototype.initialize.call(this, this._element, this._element),
                (this._container = t),
                this.on(
                    "predrag",
                    function () {
                        (this._newPos.y = 0), (this._newPos.x = this._adjustX(this._newPos.x));
                    },
                    this
                ),
                this.on("dragstart", function () {
                    L.DomUtil.addClass(t, "dragging");
                }),
                this.on("dragend", function () {
                    L.DomUtil.removeClass(t, "dragging");
                }),
                L.DomEvent.on(
                    this._element,
                    "dblclick",
                    function (t) {
                        this.fire("dblclick", t);
                    },
                    this
                ),
                L.DomEvent.disableClickPropagation(this._element),
                this.enable();
        },
        _getProjectionCoef: function () {
            return (this.options.rangeMax - this.options.rangeMin) / (this._container.offsetWidth || this._container.style.width);
        },
        _update: function () {
            this.setPosition(L.DomUtil.getPosition(this._element).x);
        },
        _adjustX: function (t) {
            var e = this._toValue(t) || this.getMinValue();
            return this._toX(this._adjustValue(e));
        },
        _adjustValue: function (t) {
            return (t = Math.max(this.getMinValue(), Math.min(this.getMaxValue(), t))), (t -= this.options.rangeMin), (t = Math.round(t / this.options.step) * this.options.step), (t += this.options.rangeMin), Math.round(100 * t) / 100;
        },
        _toX: function (t) {
            return (t - this.options.rangeMin) / this._getProjectionCoef();
        },
        _toValue: function (t) {
            return t * this._getProjectionCoef() + this.options.rangeMin;
        },
        getMinValue: function () {
            return this.options.minValue || this.options.rangeMin;
        },
        getMaxValue: function () {
            return this.options.maxValue || this.options.rangeMax;
        },
        setStep: function (t) {
            (this.options.step = t), this._update();
        },
        setPosition: function (t) {
            L.DomUtil.setPosition(this._element, L.point(this._adjustX(t), 0)), this.fire("positionchanged");
        },
        getPosition: function () {
            return L.DomUtil.getPosition(this._element).x;
        },
        setValue: function (t) {
            this.setPosition(this._toX(t));
        },
        getValue: function () {
            return this._adjustValue(this._toValue(this.getPosition()));
        },
    })),
    (L.Control.TimeDimension = L.Control.extend({
        options: {
            styleNS: "leaflet-control-timecontrol",
            position: "bottomleft",
            title: "Time Control",
            backwardButton: !0,
            forwardButton: !0,
            playButton: !0,
            playReverseButton: !1,
            loopButton: !1,
            displayDate: !0,
            timeSlider: !0,
            timeSliderDragUpdate: !1,
            limitSliders: !1,
            limitMinimumRange: 5,
            speedSlider: !0,
            minSpeed: 0.1,
            maxSpeed: 10,
            speedStep: 0.1,
            timeSteps: 1,
            autoPlay: !1,
            playerOptions: { transitionTime: 1e3 },
        },
        initialize: function (t) {
            L.Control.prototype.initialize.call(this, t), (this._dateUTC = !0), (this._timeDimension = this.options.timeDimension || null);
        },
        onAdd: function (t) {
            var e;
            return (
                (this._map = t),
                !this._timeDimension && t.timeDimension && (this._timeDimension = t.timeDimension),
                this._initPlayer(),
                (e = L.DomUtil.create("div", "leaflet-bar leaflet-bar-horizontal leaflet-bar-timecontrol")),
                this.options.backwardButton && (this._buttonBackward = this._createButton("Backward", e)),
                this.options.playReverseButton && (this._buttonPlayReversePause = this._createButton("Play Reverse", e)),
                this.options.playButton && (this._buttonPlayPause = this._createButton("Play", e)),
                this.options.forwardButton && (this._buttonForward = this._createButton("Forward", e)),
                this.options.loopButton && (this._buttonLoop = this._createButton("Loop", e)),
                this.options.displayDate && (this._displayDate = this._createButton("Date", e)),
                this.options.timeSlider && (this._sliderTime = this._createSliderTime(this.options.styleNS + " timecontrol-slider timecontrol-dateslider", e)),
                this.options.speedSlider && (this._sliderSpeed = this._createSliderSpeed(this.options.styleNS + " timecontrol-slider timecontrol-speed", e)),
                (this._steps = this.options.timeSteps || 1),
                this._timeDimension.on("timeload", this._update, this),
                this._timeDimension.on("timeload", this._onPlayerStateChange, this),
                this._timeDimension.on("timeloading", this._onTimeLoading, this),
                this._timeDimension.on("limitschanged availabletimeschanged", this._onTimeLimitsChanged, this),
                L.DomEvent.disableClickPropagation(e),
                e
            );
        },
        addTo: function () {
            return L.Control.prototype.addTo.apply(this, arguments), this._onPlayerStateChange(), this._onTimeLimitsChanged(), this._update(), this;
        },
        onRemove: function () {
            this._player.off("play stop running loopchange speedchange", this._onPlayerStateChange, this),
                this._player.off("waiting", this._onPlayerWaiting, this),
                this._timeDimension.off("timeload", this._update, this),
                this._timeDimension.off("timeload", this._onPlayerStateChange, this),
                this._timeDimension.off("timeloading", this._onTimeLoading, this),
                this._timeDimension.off("limitschanged availabletimeschanged", this._onTimeLimitsChanged, this);
        },
        _initPlayer: function () {
            this._player || (this.options.player ? (this._player = this.options.player) : (this._player = new L.TimeDimension.Player(this.options.playerOptions, this._timeDimension))),
                this.options.autoPlay && this._player.start(this._steps),
                this._player.on("play stop running loopchange speedchange", this._onPlayerStateChange, this),
                this._player.on("waiting", this._onPlayerWaiting, this),
                this._onPlayerStateChange();
        },
        _onTimeLoading: function (t) {
            t.time == this._timeDimension.getCurrentTime() && this._displayDate && L.DomUtil.addClass(this._displayDate, "loading");
        },
        _onTimeLimitsChanged: function () {
            var t = this._timeDimension.getLowerLimitIndex(),
                e = this._timeDimension.getUpperLimitIndex(),
                i = this._timeDimension.getAvailableTimes().length - 1;
            this._limitKnobs && ((this._limitKnobs[0].options.rangeMax = i), (this._limitKnobs[1].options.rangeMax = i), this._limitKnobs[0].setValue(t || 0), this._limitKnobs[1].setValue(e || i)),
                this._sliderTime && ((this._sliderTime.options.rangeMax = i), this._sliderTime._update());
        },
        _onPlayerWaiting: function (t) {
            this._buttonPlayPause && this._player.getSteps() > 0 && (L.DomUtil.addClass(this._buttonPlayPause, "loading"), (this._buttonPlayPause.innerHTML = this._getDisplayLoadingText(t.available, t.buffer))),
                this._buttonPlayReversePause && this._player.getSteps() < 0 && (L.DomUtil.addClass(this._buttonPlayReversePause, "loading"), (this._buttonPlayReversePause.innerHTML = this._getDisplayLoadingText(t.available, t.buffer)));
        },
        _onPlayerStateChange: function () {
            if (
                (this._buttonPlayPause &&
                    (this._player.isPlaying() && this._player.getSteps() > 0
                        ? (L.DomUtil.addClass(this._buttonPlayPause, "pause"), L.DomUtil.removeClass(this._buttonPlayPause, "play"))
                        : (L.DomUtil.removeClass(this._buttonPlayPause, "pause"), L.DomUtil.addClass(this._buttonPlayPause, "play")),
                    this._player.isWaiting() && this._player.getSteps() > 0 ? L.DomUtil.addClass(this._buttonPlayPause, "loading") : ((this._buttonPlayPause.innerHTML = ""), L.DomUtil.removeClass(this._buttonPlayPause, "loading"))),
                this._buttonPlayReversePause &&
                    (this._player.isPlaying() && this._player.getSteps() < 0 ? L.DomUtil.addClass(this._buttonPlayReversePause, "pause") : L.DomUtil.removeClass(this._buttonPlayReversePause, "pause"),
                    this._player.isWaiting() && this._player.getSteps() < 0
                        ? L.DomUtil.addClass(this._buttonPlayReversePause, "loading")
                        : ((this._buttonPlayReversePause.innerHTML = ""), L.DomUtil.removeClass(this._buttonPlayReversePause, "loading"))),
                this._buttonLoop && (this._player.isLooped() ? L.DomUtil.addClass(this._buttonLoop, "looped") : L.DomUtil.removeClass(this._buttonLoop, "looped")),
                this._sliderSpeed && !this._draggingSpeed)
            ) {
                var t = this._player.getTransitionTime() || 1e3;
                (t = Math.round(1e4 / t) / 10), this._sliderSpeed.setValue(t);
            }
        },
        _update: function () {
            if (this._timeDimension)
                if (this._timeDimension.getCurrentTimeIndex() >= 0) {
                    var t = new Date(this._timeDimension.getCurrentTime());
                    this._displayDate && (L.DomUtil.removeClass(this._displayDate, "loading"), (this._displayDate.innerHTML = this._getDisplayDateFormat(t))),
                        this._sliderTime && !this._slidingTimeSlider && this._sliderTime.setValue(this._timeDimension.getCurrentTimeIndex());
                } else this._displayDate && (this._displayDate.innerHTML = this._getDisplayNoTimeError());
        },
        _createButton: function (t, e) {
            var i = L.DomUtil.create("a", this.options.styleNS + " timecontrol-" + t.toLowerCase(), e);
            return (
                (i.href = "#"),
                (i.title = t),
                L.DomEvent.addListener(i, "click", L.DomEvent.stopPropagation)
                    .addListener(i, "click", L.DomEvent.preventDefault)
                    .addListener(i, "click", this["_button" + t.replace(/ /i, "") + "Clicked"], this),
                i
            );
        },
        _createSliderTime: function (t, e) {
            var i, s, o, n, a;
            return (
                (i = L.DomUtil.create("div", t, e)),
                (s = L.DomUtil.create("div", "slider", i)),
                (o = this._timeDimension.getAvailableTimes().length - 1),
                this.options.limitSliders && (a = this._limitKnobs = this._createLimitKnobs(s)),
                (n = new L.UI.Knob(s, { className: "knob main", rangeMin: 0, rangeMax: o })).on(
                    "dragend",
                    function (t) {
                        var e = t.target.getValue();
                        this._sliderTimeValueChanged(e), (this._slidingTimeSlider = !1);
                    },
                    this
                ),
                n.on(
                    "drag",
                    function (t) {
                        this._slidingTimeSlider = !0;
                        var e = this._timeDimension.getAvailableTimes()[t.target.getValue()];
                        if (e) {
                            var i = new Date(e);
                            this._displayDate && (this._displayDate.innerHTML = this._getDisplayDateFormat(i)), this.options.timeSliderDragUpdate && this._sliderTimeValueChanged(t.target.getValue());
                        }
                    },
                    this
                ),
                n.on(
                    "predrag",
                    function () {
                        var t, e;
                        a && ((t = a[0].getPosition()), (e = a[1].getPosition()), this._newPos.x < t && (this._newPos.x = t), this._newPos.x > e && (this._newPos.x = e));
                    },
                    n
                ),
                L.DomEvent.on(
                    s,
                    "click",
                    function (t) {
                        if (!L.DomUtil.hasClass(t.target, "knob")) {
                            var e = t.touches && 1 === t.touches.length ? t.touches[0] : t,
                                i = L.DomEvent.getMousePosition(e, s).x;
                            a ? a[0].getPosition() <= i && i <= a[1].getPosition() && (n.setPosition(i), this._sliderTimeValueChanged(n.getValue())) : (n.setPosition(i), this._sliderTimeValueChanged(n.getValue()));
                        }
                    },
                    this
                ),
                n.setPosition(0),
                n
            );
        },
        _createLimitKnobs: function (t) {
            L.DomUtil.addClass(t, "has-limits");
            var e = this._timeDimension.getAvailableTimes().length - 1,
                i = L.DomUtil.create("div", "range", t),
                s = new L.UI.Knob(t, { className: "knob lower", rangeMin: 0, rangeMax: e }),
                o = new L.UI.Knob(t, { className: "knob upper", rangeMin: 0, rangeMax: e });
            return (
                L.DomUtil.setPosition(i, 0),
                s.setPosition(0),
                o.setPosition(e),
                s.on(
                    "dragend",
                    function (t) {
                        var e = t.target.getValue();
                        this._sliderLimitsValueChanged(e, o.getValue());
                    },
                    this
                ),
                o.on(
                    "dragend",
                    function (t) {
                        var e = t.target.getValue();
                        this._sliderLimitsValueChanged(s.getValue(), e);
                    },
                    this
                ),
                s.on(
                    "drag positionchanged",
                    function () {
                        L.DomUtil.setPosition(i, L.point(s.getPosition(), 0)), (i.style.width = o.getPosition() - s.getPosition() + "px");
                    },
                    this
                ),
                o.on(
                    "drag positionchanged",
                    function () {
                        i.style.width = o.getPosition() - s.getPosition() + "px";
                    },
                    this
                ),
                o.on(
                    "predrag",
                    function () {
                        var t = s._toX(s.getValue() + this.options.limitMinimumRange);
                        o._newPos.x <= t && (o._newPos.x = t);
                    },
                    this
                ),
                s.on(
                    "predrag",
                    function () {
                        var t = o._toX(o.getValue() - this.options.limitMinimumRange);
                        s._newPos.x >= t && (s._newPos.x = t);
                    },
                    this
                ),
                s.on(
                    "dblclick",
                    function () {
                        this._timeDimension.setLowerLimitIndex(0);
                    },
                    this
                ),
                o.on(
                    "dblclick",
                    function () {
                        this._timeDimension.setUpperLimitIndex(this._timeDimension.getAvailableTimes().length - 1);
                    },
                    this
                ),
                [s, o]
            );
        },
        _createSliderSpeed: function (t, e) {
            var i = L.DomUtil.create("div", t, e),
                s = L.DomUtil.create("span", "speed", i),
                o = L.DomUtil.create("div", "slider", i),
                n = Math.round(1e4 / (this._player.getTransitionTime() || 1e3)) / 10;
            s.innerHTML = this._getDisplaySpeed(n);
            var a = new L.UI.Knob(o, { step: this.options.speedStep, rangeMin: this.options.minSpeed, rangeMax: this.options.maxSpeed });
            return (
                a.on(
                    "dragend",
                    function (t) {
                        var e = t.target.getValue();
                        (this._draggingSpeed = !1), (s.innerHTML = this._getDisplaySpeed(e)), this._sliderSpeedValueChanged(e);
                    },
                    this
                ),
                a.on(
                    "drag",
                    function (t) {
                        (this._draggingSpeed = !0), (s.innerHTML = this._getDisplaySpeed(t.target.getValue()));
                    },
                    this
                ),
                a.on(
                    "positionchanged",
                    function (t) {
                        s.innerHTML = this._getDisplaySpeed(t.target.getValue());
                    },
                    this
                ),
                L.DomEvent.on(
                    o,
                    "click",
                    function (t) {
                        if (t.target !== a._element) {
                            var e = t.touches && 1 === t.touches.length ? t.touches[0] : t,
                                i = L.DomEvent.getMousePosition(e, o).x;
                            a.setPosition(i), (s.innerHTML = this._getDisplaySpeed(a.getValue())), this._sliderSpeedValueChanged(a.getValue());
                        }
                    },
                    this
                ),
                a
            );
        },
        _buttonBackwardClicked: function () {
            this._timeDimension.previousTime(this._steps);
        },
        _buttonForwardClicked: function () {
            this._timeDimension.nextTime(this._steps);
        },
        _buttonLoopClicked: function () {
            this._player.setLooped(!this._player.isLooped());
        },
        _buttonPlayClicked: function () {
            this._player.isPlaying() ? this._player.stop() : this._player.start(this._steps);
        },
        _buttonPlayReverseClicked: function () {
            this._player.isPlaying() ? this._player.stop() : this._player.start(-1 * this._steps);
        },
        _buttonDateClicked: function () {
            this._toggleDateUTC();
        },
        _sliderTimeValueChanged: function (t) {
            this._timeDimension.setCurrentTimeIndex(t);
        },
        _sliderLimitsValueChanged: function (t, e) {
            this._timeDimension.setLowerLimitIndex(t), this._timeDimension.setUpperLimitIndex(e);
        },
        _sliderSpeedValueChanged: function (t) {
            this._player.setTransitionTime(1e3 / t);
        },
        _toggleDateUTC: function () {
            this._dateUTC ? (L.DomUtil.removeClass(this._displayDate, "utc"), (this._displayDate.title = "Local Time")) : (L.DomUtil.addClass(this._displayDate, "utc"), (this._displayDate.title = "UTC Time")),
                (this._dateUTC = !this._dateUTC),
                this._update();
        },
        _getDisplayDateFormat: function (t) {
            return this._dateUTC ? t.toISOString() : t.toLocaleString();
        },
        _getDisplaySpeed: function (t) {
            return t + "fps";
        },
        _getDisplayLoadingText: function (t, e) {
            return "<span>" + Math.floor((t / e) * 100) + "%</span>";
        },
        _getDisplayNoTimeError: function () {
            return "Time not available";
        },
    })),
    L.Map.addInitHook(function () {
        this.options.timeDimensionControl && ((this.timeDimensionControl = L.control.timeDimension(this.options.timeDimensionControlOptions || {})), this.addControl(this.timeDimensionControl));
    }),
    (L.control.timeDimension = function (t) {
        return new L.Control.TimeDimension(t);
    });
var GFS_server_year = 2019,
    GFS_server_month = 12,
    GFS_server_day = 23,
    GFS_server_hour = 18,
    GFS_timesteps = 81,
    GFS_interval = 3,
    WAVE_timesteps = 61,
    WAVE_interval = 3,
    RTOFS_server_year = 2019,
    RTOFS_server_month = 12,
    RTOFS_server_day = 23,
    RTOFS_server_hour = 0,
    RTOFS_timesteps = 65,
    RTOFS_interval = 3;
function convertDateFormat(t) {
    var e = t.split(" "),
        i = e[0].split("-");
    return '<span class="px-1"><i class="far fa-calendar-alt"></i> ' + (i[2] + "/" + i[1] + "/" + i[0]) + ' | <i class="far fa-clock"></i> ' + e[1].substring(0, 5) + "</span>";
}
function convertDateFormatDay(t) {
    var e = t.split(" "),
        i = e[0].split("-"),
        s = i[2] + "/" + i[1] + "/" + i[0];
    e[1].substring(0, 5);
    return '<span class="px-1"><i class="far fa-calendar-alt"></i> ' + s + "</span>";
}
function convertDateFormatHour(t) {
    var e = t.split(" "),
        i = e[0].split("-");
    i[2], i[1], i[0];
    return '<span class="px-1"><i class="far fa-clock"></i> ' + e[1].substring(0, 5) + "</span>";
}
function convertAVGDateFormat(t) {
    var e = t.split(" "),
        i = e[0].split("-");
    return "อัพเดทข้อมูลเมื่อ : " + (i[2] + "/" + i[1] + "/" + i[0]) + " เวลา " + e[1].substring(0, 5) + " น.";
}
!(function (t, e) {
    "function" == typeof define && define.amd ? define(["leaflet"], t) : "object" == typeof exports && (void 0 !== e && e.L ? (module.exports = t(L)) : (module.exports = t(require("leaflet")))),
        void 0 !== e && e.L && (e.L.Control.Locate = t(L));
})(function (t) {
    var e = function (e, i, s) {
            (s = s.split(" ")).forEach(function (s) {
                t.DomUtil[e].call(this, i, s);
            });
        },
        i = function (t, i) {
            e("addClass", t, i);
        },
        s = function (t, i) {
            e("removeClass", t, i);
        },
        o = t.Marker.extend({
            initialize: function (e, i) {
                t.Util.setOptions(this, i), (this._latlng = e), this.createIcon();
            },
            createIcon: function () {
                var e = this.options,
                    i = "";
                void 0 !== e.color && (i += "stroke:" + e.color + ";"),
                    void 0 !== e.weight && (i += "stroke-width:" + e.weight + ";"),
                    void 0 !== e.fillColor && (i += "fill:" + e.fillColor + ";"),
                    void 0 !== e.fillOpacity && (i += "fill-opacity:" + e.fillOpacity + ";"),
                    void 0 !== e.opacity && (i += "opacity:" + e.opacity + ";");
                var s = this._getIconSVG(e, i);
                (this._locationIcon = t.divIcon({ className: s.className, html: s.svg, iconSize: [s.w, s.h] })), this.setIcon(this._locationIcon);
            },
            _getIconSVG: function (t, e) {
                var i = t.radius,
                    s = i + t.weight,
                    o = 2 * s;
                return {
                    className: "leaflet-control-locate-location",
                    svg: '<svg xmlns="http://www.w3.org/2000/svg" width="' + o + '" height="' + o + '" version="1.1" viewBox="-' + s + " -" + s + " " + o + " " + o + '"><circle r="' + i + '" style="' + e + '" /></svg>',
                    w: o,
                    h: o,
                };
            },
            setStyle: function (e) {
                t.Util.setOptions(this, e), this.createIcon();
            },
        }),
        n = o.extend({
            initialize: function (e, i, s) {
                t.Util.setOptions(this, s), (this._latlng = e), (this._heading = i), this.createIcon();
            },
            setHeading: function (t) {
                this._heading = t;
            },
            _getIconSVG: function (t, e) {
                var i = t.radius,
                    s = t.width + t.weight,
                    o = 2 * (i + t.depth + t.weight),
                    n = "M0,0 l" + t.width / 2 + "," + t.depth + " l-" + s + ",0 z";
                return {
                    className: "leaflet-control-locate-heading",
                    svg:
                        '<svg xmlns="http://www.w3.org/2000/svg" width="' +
                        s +
                        '" height="' +
                        o +
                        '" version="1.1" viewBox="-' +
                        s / 2 +
                        " 0 " +
                        s +
                        " " +
                        o +
                        '" style="transform: rotate(' +
                        this._heading +
                        'deg)"><path d="' +
                        n +
                        '" style="' +
                        e +
                        '" /></svg>',
                    w: s,
                    h: o,
                };
            },
        }),
        a = t.Control.extend({
            options: {
                position: "topleft",
                layer: void 0,
                setView: "untilPanOrZoom",
                keepCurrentZoomLevel: !1,
                getLocationBounds: function (t) {
                    return t.bounds;
                },
                flyTo: !1,
                clickBehavior: { inView: "stop", outOfView: "setView", inViewNotFollowing: "inView" },
                returnToPrevBounds: !1,
                cacheLocation: !0,
                drawCircle: !0,
                drawMarker: !0,
                showCompass: !0,
                markerClass: o,
                compassClass: n,
                circleStyle: { className: "leaflet-control-locate-circle", color: "#136AEC", fillColor: "#136AEC", fillOpacity: 0.15, weight: 0 },
                markerStyle: { className: "leaflet-control-locate-marker", color: "#fff", fillColor: "#2A93EE", fillOpacity: 1, weight: 3, opacity: 1, radius: 9 },
                compassStyle: { fillColor: "#2A93EE", fillOpacity: 1, weight: 0, color: "#fff", opacity: 1, radius: 9, width: 9, depth: 6 },
                followCircleStyle: {},
                followMarkerStyle: {},
                followCompassStyle: {},
                icon: "fa fa-map-marker",
                iconLoading: "fa fa-spinner fa-spin",
                iconElementTag: "span",
                circlePadding: [0, 0],
                metric: !0,
                createButtonCallback: function (e, i) {
                    var s = t.DomUtil.create("a", "leaflet-bar-part leaflet-bar-part-single", e);
                    return (s.title = i.strings.title), { link: s, icon: t.DomUtil.create(i.iconElementTag, i.icon, s) };
                },
                onLocationError: function (t, e) {
                    alert(t.message);
                },
                onLocationOutsideMapBounds: function (t) {
                    t.stop(), alert(t.options.strings.outsideMapBoundsMsg);
                },
                showPopup: !0,
                strings: { title: "Show me where I am", metersUnit: "meters", feetUnit: "feet", popup: "You are within {distance} {unit} from this point", outsideMapBoundsMsg: "You seem located outside the boundaries of the map" },
                locateOptions: { maxZoom: 1 / 0, watch: !0, setView: !1 },
            },
            initialize: function (e) {
                for (var i in e) "object" == typeof this.options[i] ? t.extend(this.options[i], e[i]) : (this.options[i] = e[i]);
                (this.options.followMarkerStyle = t.extend({}, this.options.markerStyle, this.options.followMarkerStyle)),
                    (this.options.followCircleStyle = t.extend({}, this.options.circleStyle, this.options.followCircleStyle)),
                    (this.options.followCompassStyle = t.extend({}, this.options.compassStyle, this.options.followCompassStyle));
            },
            onAdd: function (e) {
                var i = t.DomUtil.create("div", "leaflet-control-locate leaflet-bar leaflet-control");
                (this._layer = this.options.layer || new t.LayerGroup()), this._layer.addTo(e), (this._event = void 0), (this._compassHeading = null), (this._prevBounds = null);
                var s = this.options.createButtonCallback(i, this.options);
                return (
                    (this._link = s.link),
                    (this._icon = s.icon),
                    t.DomEvent.on(this._link, "click", t.DomEvent.stopPropagation).on(this._link, "click", t.DomEvent.preventDefault).on(this._link, "click", this._onClick, this).on(this._link, "dblclick", t.DomEvent.stopPropagation),
                    this._resetVariables(),
                    this._map.on("unload", this._unload, this),
                    i
                );
            },
            _onClick: function () {
                this._justClicked = !0;
                var t = this._isFollowing();
                if (((this._userPanned = !1), (this._userZoomed = !1), this._active && !this._event)) this.stop();
                else if (this._active && void 0 !== this._event) {
                    var e = this.options.clickBehavior,
                        i = e.outOfView;
                    switch ((this._map.getBounds().contains(this._event.latlng) && (i = t ? e.inView : e.inViewNotFollowing), e[i] && (i = e[i]), i)) {
                        case "setView":
                            this.setView();
                            break;
                        case "stop":
                            this.stop(), this.options.returnToPrevBounds && (this.options.flyTo ? this._map.flyToBounds : this._map.fitBounds).bind(this._map)(this._prevBounds);
                    }
                } else this.options.returnToPrevBounds && (this._prevBounds = this._map.getBounds()), this.start();
                this._updateContainerStyle();
            },
            start: function () {
                this._activate(), this._event && (this._drawMarker(this._map), this.options.setView && this.setView()), this._updateContainerStyle();
            },
            stop: function () {
                this._deactivate(), this._cleanClasses(), this._resetVariables(), this._removeMarker();
            },
            stopFollowing: function () {
                (this._userPanned = !0), this._updateContainerStyle(), this._drawMarker();
            },
            _activate: function () {
                if (
                    !this._active &&
                    (this._map.locate(this.options.locateOptions),
                    (this._active = !0),
                    this._map.on("locationfound", this._onLocationFound, this),
                    this._map.on("locationerror", this._onLocationError, this),
                    this._map.on("dragstart", this._onDrag, this),
                    this._map.on("zoomstart", this._onZoom, this),
                    this._map.on("zoomend", this._onZoomEnd, this),
                    this.options.showCompass)
                ) {
                    var e = "ondeviceorientationabsolute" in window;
                    if (e || "ondeviceorientation" in window) {
                        var i = this,
                            s = function () {
                                t.DomEvent.on(window, e ? "deviceorientationabsolute" : "deviceorientation", i._onDeviceOrientation, i);
                            };
                        DeviceOrientationEvent && "function" == typeof DeviceOrientationEvent.requestPermission
                            ? DeviceOrientationEvent.requestPermission().then(function (t) {
                                  "granted" === t && s();
                              })
                            : s();
                    }
                }
            },
            _deactivate: function () {
                this._map.stopLocate(),
                    (this._active = !1),
                    this.options.cacheLocation || (this._event = void 0),
                    this._map.off("locationfound", this._onLocationFound, this),
                    this._map.off("locationerror", this._onLocationError, this),
                    this._map.off("dragstart", this._onDrag, this),
                    this._map.off("zoomstart", this._onZoom, this),
                    this._map.off("zoomend", this._onZoomEnd, this),
                    this.options.showCompass &&
                        ((this._compassHeading = null),
                        "ondeviceorientationabsolute" in window
                            ? t.DomEvent.off(window, "deviceorientationabsolute", this._onDeviceOrientation, this)
                            : "ondeviceorientation" in window && t.DomEvent.off(window, "deviceorientation", this._onDeviceOrientation, this));
            },
            setView: function () {
                if ((this._drawMarker(), this._isOutsideMapBounds())) (this._event = void 0), this.options.onLocationOutsideMapBounds(this);
                else if (this.options.keepCurrentZoomLevel) (e = this.options.flyTo ? this._map.flyTo : this._map.panTo).bind(this._map)([this._event.latitude, this._event.longitude]);
                else {
                    var e = this.options.flyTo ? this._map.flyToBounds : this._map.fitBounds;
                    (this._ignoreEvent = !0),
                        e.bind(this._map)(this.options.getLocationBounds(this._event), { padding: this.options.circlePadding, maxZoom: this.options.locateOptions.maxZoom }),
                        t.Util.requestAnimFrame(function () {
                            this._ignoreEvent = !1;
                        }, this);
                }
            },
            _drawCompass: function () {
                if (this._event) {
                    var t = this._event.latlng;
                    if (this.options.showCompass && t && null !== this._compassHeading) {
                        var e = this._isFollowing() ? this.options.followCompassStyle : this.options.compassStyle;
                        this._compass
                            ? (this._compass.setLatLng(t), this._compass.setHeading(this._compassHeading), this._compass.setStyle && this._compass.setStyle(e))
                            : (this._compass = new this.options.compassClass(t, this._compassHeading, e).addTo(this._layer));
                    }
                    !this._compass || (this.options.showCompass && null !== this._compassHeading) || (this._compass.removeFrom(this._layer), (this._compass = null));
                }
            },
            _drawMarker: function () {
                void 0 === this._event.accuracy && (this._event.accuracy = 0);
                var e,
                    i,
                    s = this._event.accuracy,
                    o = this._event.latlng;
                if (this.options.drawCircle) {
                    var n = this._isFollowing() ? this.options.followCircleStyle : this.options.circleStyle;
                    this._circle ? this._circle.setLatLng(o).setRadius(s).setStyle(n) : (this._circle = t.circle(o, s, n).addTo(this._layer));
                }
                if ((this.options.metric ? ((e = s.toFixed(0)), (i = this.options.strings.metersUnit)) : ((e = (3.2808399 * s).toFixed(0)), (i = this.options.strings.feetUnit)), this.options.drawMarker)) {
                    var a = this._isFollowing() ? this.options.followMarkerStyle : this.options.markerStyle;
                    this._marker ? (this._marker.setLatLng(o), this._marker.setStyle && this._marker.setStyle(a)) : (this._marker = new this.options.markerClass(o, a).addTo(this._layer));
                }
                this._drawCompass();
                var r = this.options.strings.popup;
                this.options.showPopup && r && this._marker && this._marker.bindPopup(t.Util.template(r, { distance: e, unit: i }))._popup.setLatLng(o),
                    this.options.showPopup && r && this._compass && this._compass.bindPopup(t.Util.template(r, { distance: e, unit: i }))._popup.setLatLng(o);
            },
            _removeMarker: function () {
                this._layer.clearLayers(), (this._marker = void 0), (this._circle = void 0);
            },
            _unload: function () {
                this.stop(), this._map.off("unload", this._unload, this);
            },
            _setCompassHeading: function (e) {
                !isNaN(parseFloat(e)) && isFinite(e) ? ((e = Math.round(e)), (this._compassHeading = e), t.Util.requestAnimFrame(this._drawCompass, this)) : (this._compassHeading = null);
            },
            _onCompassNeedsCalibration: function () {
                this._setCompassHeading();
            },
            _onDeviceOrientation: function (t) {
                this._active && (t.webkitCompassHeading ? this._setCompassHeading(t.webkitCompassHeading) : t.absolute && t.alpha && this._setCompassHeading(360 - t.alpha));
            },
            _onLocationError: function (t) {
                (3 == t.code && this.options.locateOptions.watch) || (this.stop(), this.options.onLocationError(t, this));
            },
            _onLocationFound: function (t) {
                if ((!this._event || this._event.latlng.lat !== t.latlng.lat || this._event.latlng.lng !== t.latlng.lng || this._event.accuracy !== t.accuracy) && this._active) {
                    switch (((this._event = t), this._drawMarker(), this._updateContainerStyle(), this.options.setView)) {
                        case "once":
                            this._justClicked && this.setView();
                            break;
                        case "untilPan":
                            this._userPanned || this.setView();
                            break;
                        case "untilPanOrZoom":
                            this._userPanned || this._userZoomed || this.setView();
                            break;
                        case "always":
                            this.setView();
                    }
                    this._justClicked = !1;
                }
            },
            _onDrag: function () {
                this._event && !this._ignoreEvent && ((this._userPanned = !0), this._updateContainerStyle(), this._drawMarker());
            },
            _onZoom: function () {
                this._event && !this._ignoreEvent && ((this._userZoomed = !0), this._updateContainerStyle(), this._drawMarker());
            },
            _onZoomEnd: function () {
                this._event && this._drawCompass(),
                    this._event && !this._ignoreEvent && this._marker && !this._map.getBounds().pad(-0.3).contains(this._marker.getLatLng()) && ((this._userPanned = !0), this._updateContainerStyle(), this._drawMarker());
            },
            _isFollowing: function () {
                return !!this._active && ("always" === this.options.setView || ("untilPan" === this.options.setView ? !this._userPanned : "untilPanOrZoom" === this.options.setView ? !this._userPanned && !this._userZoomed : void 0));
            },
            _isOutsideMapBounds: function () {
                return void 0 !== this._event && this._map.options.maxBounds && !this._map.options.maxBounds.contains(this._event.latlng);
            },
            _updateContainerStyle: function () {
                this._container && (this._active && !this._event ? this._setClasses("requesting") : this._isFollowing() ? this._setClasses("following") : this._active ? this._setClasses("active") : this._cleanClasses());
            },
            _setClasses: function (t) {
                "requesting" == t
                    ? (s(this._container, "active following"), i(this._container, "requesting"), s(this._icon, this.options.icon), i(this._icon, this.options.iconLoading))
                    : "active" == t
                    ? (s(this._container, "requesting following"), i(this._container, "active"), s(this._icon, this.options.iconLoading), i(this._icon, this.options.icon))
                    : "following" == t && (s(this._container, "requesting"), i(this._container, "active following"), s(this._icon, this.options.iconLoading), i(this._icon, this.options.icon));
            },
            _cleanClasses: function () {
                t.DomUtil.removeClass(this._container, "requesting"),
                    t.DomUtil.removeClass(this._container, "active"),
                    t.DomUtil.removeClass(this._container, "following"),
                    s(this._icon, this.options.iconLoading),
                    i(this._icon, this.options.icon);
            },
            _resetVariables: function () {
                (this._active = !1), (this._justClicked = !1), (this._userPanned = !1), (this._userZoomed = !1);
            },
        });
    return (
        (t.control.locate = function (e) {
            return new t.Control.Locate(e);
        }),
        a
    );
}, window),
    (function (t) {
        if ("function" == typeof define && define.amd) define(["leaflet"], t);
        else if ("undefined" != typeof module) module.exports = t(require("leaflet"));
        else {
            if (void 0 === window.L) throw "Leaflet must be loaded first";
            t(window.L);
        }
    })(function (t) {
        return (
            (t.Control.Search = t.Control.extend({
                includes: "1" === t.version[0] ? t.Evented.prototype : t.Mixin.Events,
                options: {
                    url: "",
                    layer: null,
                    sourceData: null,
                    jsonpParam: null,
                    propertyLoc: "loc",
                    propertyName: "title",
                    formatData: null,
                    filterData: null,
                    moveToLocation: null,
                    buildTip: null,
                    container: "",
                    zoom: null,
                    minLength: 1,
                    initial: !0,
                    casesensitive: !1,
                    autoType: !0,
                    delayType: 400,
                    tooltipLimit: -1,
                    tipAutoSubmit: !0,
                    firstTipSubmit: !1,
                    autoResize: !0,
                    collapsed: !0,
                    autoCollapse: !1,
                    autoCollapseTime: 1200,
                    textErr: "Location not found",
                    textCancel: "Cancel",
                    textPlaceholder: "Search...",
                    hideMarkerOnCollapse: !1,
                    position: "topleft",
                    marker: { icon: !1, animate: !0, circle: { radius: 10, weight: 3, color: "#e03", stroke: !0, fill: !1 } },
                },
                _getPath: function (t, e) {
                    var i = e.split("."),
                        s = i.pop(),
                        o = i.length,
                        n = i[0],
                        a = 1;
                    if (o > 0) for (; (t = t[n]) && a < o; ) n = i[a++];
                    if (t) return t[s];
                },
                _isObject: function (t) {
                    return "[object Object]" === Object.prototype.toString.call(t);
                },
                initialize: function (e) {
                    t.Util.setOptions(this, e || {}),
                        (this._inputMinSize = this.options.textPlaceholder ? this.options.textPlaceholder.length : 10),
                        (this._layer = this.options.layer || new t.LayerGroup()),
                        (this._filterData = this.options.filterData || this._defaultFilterData),
                        (this._formatData = this.options.formatData || this._defaultFormatData),
                        (this._moveToLocation = this.options.moveToLocation || this._defaultMoveToLocation),
                        (this._autoTypeTmp = this.options.autoType),
                        (this._countertips = 0),
                        (this._recordsCache = {}),
                        (this._curReq = null);
                },
                onAdd: function (e) {
                    return (
                        (this._map = e),
                        (this._container = t.DomUtil.create("div", "leaflet-control-search")),
                        (this._input = this._createInput(this.options.textPlaceholder, "search-input")),
                        (this._tooltip = this._createTooltip("search-tooltip")),
                        (this._cancel = this._createCancel(this.options.textCancel, "search-cancel")),
                        (this._button = this._createButton(this.options.textPlaceholder, "search-button")),
                        (this._alert = this._createAlert("search-alert")),
                        !1 === this.options.collapsed && this.expand(this.options.collapsed),
                        this.options.marker &&
                            (this.options.marker instanceof t.Marker || this.options.marker instanceof t.CircleMarker
                                ? (this._markerSearch = this.options.marker)
                                : this._isObject(this.options.marker) && (this._markerSearch = new t.Control.Search.Marker([0, 0], this.options.marker)),
                            (this._markerSearch._isMarkerSearch = !0)),
                        this.setLayer(this._layer),
                        e.on({ resize: this._handleAutoresize }, this),
                        this._container
                    );
                },
                addTo: function (e) {
                    return (
                        this.options.container
                            ? ((this._container = this.onAdd(e)), (this._wrapper = t.DomUtil.get(this.options.container)), (this._wrapper.style.position = "relative"), this._wrapper.appendChild(this._container))
                            : t.Control.prototype.addTo.call(this, e),
                        this
                    );
                },
                onRemove: function (t) {
                    (this._recordsCache = {}), t.off({ resize: this._handleAutoresize }, this);
                },
                setLayer: function (t) {
                    return (this._layer = t), this._layer.addTo(this._map), this;
                },
                showAlert: function (t) {
                    var e = this;
                    return (
                        (t = t || this.options.textErr),
                        (this._alert.style.display = "block"),
                        (this._alert.innerHTML = t),
                        clearTimeout(this.timerAlert),
                        (this.timerAlert = setTimeout(function () {
                            e.hideAlert();
                        }, this.options.autoCollapseTime)),
                        this
                    );
                },
                hideAlert: function () {
                    return (this._alert.style.display = "none"), this;
                },
                cancel: function () {
                    return (
                        (this._input.value = ""),
                        this._handleKeypress({ keyCode: 8 }),
                        (this._input.size = this._inputMinSize),
                        this._input.focus(),
                        (this._cancel.style.display = "none"),
                        this._hideTooltip(),
                        this.fire("search:cancel"),
                        this
                    );
                },
                expand: function (e) {
                    return (
                        (e = "boolean" != typeof e || e),
                        (this._input.style.display = "block"),
                        t.DomUtil.addClass(this._container, "search-exp"),
                        !1 !== e && (this._input.focus(), this._map.on("dragstart click", this.collapse, this)),
                        this.fire("search:expanded"),
                        this
                    );
                },
                collapse: function () {
                    return (
                        this._hideTooltip(),
                        this.cancel(),
                        (this._alert.style.display = "none"),
                        this._input.blur(),
                        this.options.collapsed &&
                            ((this._input.style.display = "none"),
                            (this._cancel.style.display = "none"),
                            t.DomUtil.removeClass(this._container, "search-exp"),
                            this.options.hideMarkerOnCollapse && this._map.removeLayer(this._markerSearch),
                            this._map.off("dragstart click", this.collapse, this)),
                        this.fire("search:collapsed"),
                        this
                    );
                },
                collapseDelayed: function () {
                    var t = this;
                    return this.options.autoCollapse
                        ? (clearTimeout(this.timerCollapse),
                          (this.timerCollapse = setTimeout(function () {
                              t.collapse();
                          }, this.options.autoCollapseTime)),
                          this)
                        : this;
                },
                collapseDelayedStop: function () {
                    return clearTimeout(this.timerCollapse), this;
                },
                _createAlert: function (e) {
                    var i = t.DomUtil.create("div", e, this._container);
                    return (i.style.display = "none"), t.DomEvent.on(i, "click", t.DomEvent.stop, this).on(i, "click", this.hideAlert, this), i;
                },
                _createInput: function (e, i) {
                    var s = this,
                        o = t.DomUtil.create("label", i, this._container),
                        n = t.DomUtil.create("input", i, this._container);
                    return (
                        (n.type = "text"),
                        (n.size = this._inputMinSize),
                        (n.value = ""),
                        (n.autocomplete = "off"),
                        (n.autocorrect = "off"),
                        (n.autocapitalize = "off"),
                        (n.placeholder = e),
                        (n.style.display = "none"),
                        (n.role = "search"),
                        (n.id = n.role + n.type + n.size),
                        (o.htmlFor = n.id),
                        (o.style.display = "none"),
                        (o.value = e),
                        t.DomEvent.disableClickPropagation(n)
                            .on(n, "keyup", this._handleKeypress, this)
                            .on(
                                n,
                                "paste",
                                function (t) {
                                    setTimeout(
                                        function (t) {
                                            s._handleKeypress(t);
                                        },
                                        10,
                                        t
                                    );
                                },
                                this
                            )
                            .on(n, "blur", this.collapseDelayed, this)
                            .on(n, "focus", this.collapseDelayedStop, this),
                        n
                    );
                },
                _createCancel: function (e, i) {
                    var s = t.DomUtil.create("a", i, this._container);
                    return (s.href = "#"), (s.title = e), (s.style.display = "none"), (s.innerHTML = "<span>&otimes;</span>"), t.DomEvent.on(s, "click", t.DomEvent.stop, this).on(s, "click", this.cancel, this), s;
                },
                _createButton: function (e, i) {
                    var s = t.DomUtil.create("a", i, this._container);
                    return (s.href = "#"), (s.title = e), t.DomEvent.on(s, "click", t.DomEvent.stop, this).on(s, "click", this._handleSubmit, this).on(s, "focus", this.collapseDelayedStop, this).on(s, "blur", this.collapseDelayed, this), s;
                },
                _createTooltip: function (e) {
                    var i = this,
                        s = t.DomUtil.create("ul", e, this._container);
                    return (
                        (s.style.display = "none"),
                        t.DomEvent.disableClickPropagation(s)
                            .on(s, "blur", this.collapseDelayed, this)
                            .on(
                                s,
                                "mousewheel",
                                function (e) {
                                    i.collapseDelayedStop(), t.DomEvent.stopPropagation(e);
                                },
                                this
                            )
                            .on(
                                s,
                                "mouseover",
                                function (t) {
                                    i.collapseDelayedStop();
                                },
                                this
                            ),
                        s
                    );
                },
                _createTip: function (e, i) {
                    var s;
                    if (this.options.buildTip) {
                        if ("string" == typeof (s = this.options.buildTip.call(this, e, i))) {
                            var o = t.DomUtil.create("div");
                            (o.innerHTML = s), (s = o.firstChild);
                        }
                    } else (s = t.DomUtil.create("li", "")).innerHTML = e;
                    return (
                        t.DomUtil.addClass(s, "search-tip"),
                        (s._text = e),
                        this.options.tipAutoSubmit &&
                            t.DomEvent.disableClickPropagation(s)
                                .on(s, "click", t.DomEvent.stop, this)
                                .on(
                                    s,
                                    "click",
                                    function (t) {
                                        (this._input.value = e), this._handleAutoresize(), this._input.focus(), this._hideTooltip(), this._handleSubmit();
                                    },
                                    this
                                ),
                        s
                    );
                },
                _getUrl: function (t) {
                    return "function" == typeof this.options.url ? this.options.url(t) : this.options.url;
                },
                _defaultFilterData: function (t, e) {
                    var i,
                        s,
                        o,
                        n = {};
                    if ("" === (t = t.replace(/[.*+?^${}()|[\]\\]/g, ""))) return [];
                    for (var a in ((i = this.options.initial ? "^" : ""), (s = this.options.casesensitive ? void 0 : "i"), (o = new RegExp(i + t, s)), e)) o.test(a) && (n[a] = e[a]);
                    return n;
                },
                showTooltip: function (t) {
                    if (((this._countertips = 0), (this._tooltip.innerHTML = ""), (this._tooltip.currentSelection = -1), this.options.tooltipLimit))
                        for (var e in t) {
                            if (this._countertips === this.options.tooltipLimit) break;
                            this._countertips++, this._tooltip.appendChild(this._createTip(e, t[e]));
                        }
                    return (
                        this._countertips > 0 ? ((this._tooltip.style.display = "block"), this._autoTypeTmp && this._autoType(), (this._autoTypeTmp = this.options.autoType)) : this._hideTooltip(),
                        (this._tooltip.scrollTop = 0),
                        this._countertips
                    );
                },
                _hideTooltip: function () {
                    return (this._tooltip.style.display = "none"), (this._tooltip.innerHTML = ""), 0;
                },
                _defaultFormatData: function (e) {
                    var i,
                        s = this.options.propertyName,
                        o = this.options.propertyLoc,
                        n = {};
                    if (t.Util.isArray(o)) for (i in e) n[this._getPath(e[i], s)] = t.latLng(e[i][o[0]], e[i][o[1]]);
                    else for (i in e) n[this._getPath(e[i], s)] = t.latLng(this._getPath(e[i], o));
                    return n;
                },
                _recordsFromJsonp: function (e, i) {
                    t.Control.Search.callJsonp = i;
                    var s = t.DomUtil.create("script", "leaflet-search-jsonp", document.getElementsByTagName("body")[0]),
                        o = t.Util.template(this._getUrl(e) + "&" + this.options.jsonpParam + "=L.Control.Search.callJsonp", { s: e });
                    return (
                        (s.type = "text/javascript"),
                        (s.src = o),
                        {
                            abort: function () {
                                s.parentNode.removeChild(s);
                            },
                        }
                    );
                },
                _recordsFromAjax: function (e, i) {
                    void 0 === window.XMLHttpRequest &&
                        (window.XMLHttpRequest = function () {
                            try {
                                return new ActiveXObject("Microsoft.XMLHTTP.6.0");
                            } catch (t) {
                                try {
                                    return new ActiveXObject("Microsoft.XMLHTTP.3.0");
                                } catch (t) {
                                    throw new Error("XMLHttpRequest is not supported");
                                }
                            }
                        });
                    var s = t.Browser.ie && !window.atob && document.querySelector ? new XDomainRequest() : new XMLHttpRequest(),
                        o = t.Util.template(this._getUrl(e), { s: e });
                    return (
                        s.open("GET", o),
                        (s.onload = function () {
                            i(JSON.parse(s.responseText));
                        }),
                        (s.onreadystatechange = function () {
                            4 === s.readyState && 200 === s.status && this.onload();
                        }),
                        s.send(),
                        s
                    );
                },
                _searchInLayer: function (e, i, s) {
                    var o,
                        n = this;
                    e instanceof t.Control.Search.Marker ||
                        (e instanceof t.Marker || e instanceof t.CircleMarker
                            ? n._getPath(e.options, s)
                                ? (((o = e.getLatLng()).layer = e), (i[n._getPath(e.options, s)] = o))
                                : n._getPath(e.feature.properties, s)
                                ? (((o = e.getLatLng()).layer = e), (i[n._getPath(e.feature.properties, s)] = o))
                                : console.warn("propertyName '" + s + "' not found in marker")
                            : e instanceof t.Path || e instanceof t.Polyline || e instanceof t.Polygon
                            ? n._getPath(e.options, s)
                                ? (((o = e.getBounds().getCenter()).layer = e), (i[n._getPath(e.options, s)] = o))
                                : n._getPath(e.feature.properties, s)
                                ? (((o = e.getBounds().getCenter()).layer = e), (i[n._getPath(e.feature.properties, s)] = o))
                                : console.warn("propertyName '" + s + "' not found in shape")
                            : e.hasOwnProperty("feature")
                            ? e.feature.properties.hasOwnProperty(s)
                                ? e.getLatLng && "function" == typeof e.getLatLng
                                    ? (((o = e.getLatLng()).layer = e), (i[e.feature.properties[s]] = o))
                                    : e.getBounds && "function" == typeof e.getBounds
                                    ? (((o = e.getBounds().getCenter()).layer = e), (i[e.feature.properties[s]] = o))
                                    : console.warn("Unknown type of Layer")
                                : console.warn("propertyName '" + s + "' not found in feature")
                            : e instanceof t.LayerGroup &&
                              e.eachLayer(function (t) {
                                  n._searchInLayer(t, i, s);
                              }));
                },
                _recordsFromLayer: function () {
                    var t = this,
                        e = {},
                        i = this.options.propertyName;
                    return (
                        this._layer.eachLayer(function (s) {
                            t._searchInLayer(s, e, i);
                        }),
                        e
                    );
                },
                _autoType: function () {
                    var t = this._input.value.length,
                        e = this._tooltip.firstChild ? this._tooltip.firstChild._text : "",
                        i = e.length;
                    if (0 === e.indexOf(this._input.value))
                        if (((this._input.value = e), this._handleAutoresize(), this._input.createTextRange)) {
                            var s = this._input.createTextRange();
                            s.collapse(!0), s.moveStart("character", t), s.moveEnd("character", i), s.select();
                        } else this._input.setSelectionRange ? this._input.setSelectionRange(t, i) : this._input.selectionStart && ((this._input.selectionStart = t), (this._input.selectionEnd = i));
                },
                _hideAutoType: function () {
                    var t;
                    if ((t = this._input.selection) && t.empty) t.empty();
                    else if (this._input.createTextRange) {
                        (t = this._input.createTextRange()).collapse(!0);
                        var e = this._input.value.length;
                        t.moveStart("character", e), t.moveEnd("character", e), t.select();
                    } else this._input.getSelection && this._input.getSelection().removeAllRanges(), (this._input.selectionStart = this._input.selectionEnd);
                },
                _handleKeypress: function (t) {
                    var e = this;
                    switch (t.keyCode) {
                        case 27:
                            this.collapse();
                            break;
                        case 13:
                            (1 == this._countertips || (this.options.firstTipSubmit && this._countertips > 0)) && -1 == this._tooltip.currentSelection && this._handleArrowSelect(1), this._handleSubmit();
                            break;
                        case 38:
                            this._handleArrowSelect(-1);
                            break;
                        case 40:
                            this._handleArrowSelect(1);
                            break;
                        case 8:
                        case 45:
                        case 46:
                            this._autoTypeTmp = !1;
                            break;
                        case 37:
                        case 39:
                        case 16:
                        case 17:
                        case 35:
                        case 36:
                            break;
                        default:
                            this._input.value.length ? (this._cancel.style.display = "block") : (this._cancel.style.display = "none"),
                                this._input.value.length >= this.options.minLength
                                    ? (clearTimeout(this.timerKeypress),
                                      (this.timerKeypress = setTimeout(function () {
                                          e._fillRecordsCache();
                                      }, this.options.delayType)))
                                    : this._hideTooltip();
                    }
                    this._handleAutoresize();
                },
                searchText: function (e) {
                    var i = e.charCodeAt(e.length);
                    (this._input.value = e), (this._input.style.display = "block"), t.DomUtil.addClass(this._container, "search-exp"), (this._autoTypeTmp = !1), this._handleKeypress({ keyCode: i });
                },
                _fillRecordsCache: function () {
                    var e,
                        i = this,
                        s = this._input.value;
                    this._curReq && this._curReq.abort && this._curReq.abort(),
                        t.DomUtil.addClass(this._container, "search-load"),
                        this.options.layer
                            ? ((this._recordsCache = this._recordsFromLayer()), (e = this._filterData(this._input.value, this._recordsCache)), this.showTooltip(e), t.DomUtil.removeClass(this._container, "search-load"))
                            : (this.options.sourceData ? (this._retrieveData = this.options.sourceData) : this.options.url && (this._retrieveData = this.options.jsonpParam ? this._recordsFromJsonp : this._recordsFromAjax),
                              (this._curReq = this._retrieveData.call(this, s, function (s) {
                                  (i._recordsCache = i._formatData.call(i, s)),
                                      (e = i.options.sourceData ? i._filterData(i._input.value, i._recordsCache) : i._recordsCache),
                                      i.showTooltip(e),
                                      t.DomUtil.removeClass(i._container, "search-load");
                              })));
                },
                _handleAutoresize: function () {
                    var t;
                    this._input.style.maxWidth !== this._map._container.offsetWidth && ((t = this._map._container.clientWidth), (t -= 83), (this._input.style.maxWidth = t.toString() + "px")),
                        this.options.autoResize && this._container.offsetWidth + 20 < this._map._container.offsetWidth && (this._input.size = this._input.value.length < this._inputMinSize ? this._inputMinSize : this._input.value.length);
                },
                _handleArrowSelect: function (e) {
                    var s = this._tooltip.hasChildNodes() ? this._tooltip.childNodes : [];
                    for (i = 0; i < s.length; i++) t.DomUtil.removeClass(s[i], "search-tip-select");
                    if (1 == e && this._tooltip.currentSelection >= s.length - 1) t.DomUtil.addClass(s[this._tooltip.currentSelection], "search-tip-select");
                    else if (-1 == e && this._tooltip.currentSelection <= 0) this._tooltip.currentSelection = -1;
                    else if ("none" != this._tooltip.style.display) {
                        (this._tooltip.currentSelection += e), t.DomUtil.addClass(s[this._tooltip.currentSelection], "search-tip-select"), (this._input.value = s[this._tooltip.currentSelection]._text);
                        var o = s[this._tooltip.currentSelection].offsetTop;
                        o + s[this._tooltip.currentSelection].clientHeight >= this._tooltip.scrollTop + this._tooltip.clientHeight
                            ? (this._tooltip.scrollTop = o - this._tooltip.clientHeight + s[this._tooltip.currentSelection].clientHeight)
                            : o <= this._tooltip.scrollTop && (this._tooltip.scrollTop = o);
                    }
                },
                _handleSubmit: function () {
                    if ((this._hideAutoType(), this.hideAlert(), this._hideTooltip(), "none" == this._input.style.display)) this.expand();
                    else if ("" === this._input.value) this.collapse();
                    else {
                        var t = this._getLocation(this._input.value);
                        !1 === t ? this.showAlert() : (this.showLocation(t, this._input.value), this.fire("search:locationfound", { latlng: t, text: this._input.value, layer: t.layer ? t.layer : null }));
                    }
                },
                _getLocation: function (t) {
                    return !!this._recordsCache.hasOwnProperty(t) && this._recordsCache[t];
                },
                _defaultMoveToLocation: function (t, e, i) {
                    this.options.zoom ? this._map.setView(t, this.options.zoom) : this._map.panTo(t);
                },
                showLocation: function (t, e) {
                    var i = this;
                    return (
                        i._map.once("moveend zoomend", function (e) {
                            i._markerSearch && i._markerSearch.addTo(i._map).setLatLng(t);
                        }),
                        i._moveToLocation(t, e, i._map),
                        i.options.autoCollapse && i.collapse(),
                        i
                    );
                },
            })),
            (t.Control.Search.Marker = t.Marker.extend({
                includes: "1" === t.version[0] ? t.Evented.prototype : t.Mixin.Events,
                options: { icon: new t.Icon.Default(), animate: !0, circle: { radius: 10, weight: 3, color: "#e03", stroke: !0, fill: !1 } },
                initialize: function (e, i) {
                    t.setOptions(this, i),
                        !0 === i.icon && (i.icon = new t.Icon.Default()),
                        t.Marker.prototype.initialize.call(this, e, i),
                        t.Control.Search.prototype._isObject(this.options.circle) && (this._circleLoc = new t.CircleMarker(e, this.options.circle));
                },
                onAdd: function (e) {
                    t.Marker.prototype.onAdd.call(this, e), this._circleLoc && (e.addLayer(this._circleLoc), this.options.animate && this.animate());
                },
                onRemove: function (e) {
                    t.Marker.prototype.onRemove.call(this, e), this._circleLoc && e.removeLayer(this._circleLoc);
                },
                setLatLng: function (e) {
                    return t.Marker.prototype.setLatLng.call(this, e), this._circleLoc && this._circleLoc.setLatLng(e), this;
                },
                _initIcon: function () {
                    this.options.icon && t.Marker.prototype._initIcon.call(this);
                },
                _removeIcon: function () {
                    this.options.icon && t.Marker.prototype._removeIcon.call(this);
                },
                animate: function () {
                    if (this._circleLoc) {
                        var t = this._circleLoc,
                            e = parseInt(t._radius / 5),
                            i = this.options.circle.radius,
                            s = 2 * t._radius,
                            o = 0;
                        t._timerAnimLoc = setInterval(function () {
                            (s -= e += o += 0.5), t.setRadius(s), s < i && (clearInterval(t._timerAnimLoc), t.setRadius(i));
                        }, 200);
                    }
                    return this;
                },
            })),
            t.Map.addInitHook(function () {
                this.options.searchControl && ((this.searchControl = t.control.search(this.options.searchControl)), this.addControl(this.searchControl));
            }),
            (t.control.search = function (e) {
                return new t.Control.Search(e);
            }),
            t.Control.Search
        );
    }),
    (function (t, e) {
        var i, s;
        "object" == typeof exports && "undefined" != typeof module
            ? (module.exports = e())
            : "function" == typeof define && define.amd
            ? define(e)
            : ((t = t || self),
              (i = t.Cookies),
              ((s = t.Cookies = e()).noConflict = function () {
                  return (t.Cookies = i), s;
              }));
    })(this, function () {
        "use strict";
        var t = {
            read: function (t) {
                return t.replace(/(%[\dA-F]{2})+/gi, decodeURIComponent);
            },
            write: function (t) {
                return encodeURIComponent(t).replace(/%(2[346BF]|3[AC-F]|40|5[BDE]|60|7[BCD])/g, decodeURIComponent);
            },
        };
        function e(t) {
            for (var e = 1; e < arguments.length; e++) {
                var i = arguments[e];
                for (var s in i) t[s] = i[s];
            }
            return t;
        }
        return (function i(s, o) {
            function n(t, i, n) {
                if ("undefined" != typeof document) {
                    "number" == typeof (n = e({}, o, n)).expires && (n.expires = new Date(Date.now() + 864e5 * n.expires)),
                        n.expires && (n.expires = n.expires.toUTCString()),
                        (i = s.write(i, t)),
                        (t = encodeURIComponent(t)
                            .replace(/%(2[346B]|5E|60|7C)/g, decodeURIComponent)
                            .replace(/[()]/g, escape));
                    var a = "";
                    for (var r in n) n[r] && ((a += "; " + r), !0 !== n[r] && (a += "=" + n[r].split(";")[0]));
                    return (document.cookie = t + "=" + i + a);
                }
            }
            return Object.create(
                {
                    set: n,
                    get: function (e) {
                        if ("undefined" != typeof document && (!arguments.length || e)) {
                            for (var i = document.cookie ? document.cookie.split("; ") : [], o = {}, n = 0; n < i.length; n++) {
                                var a = i[n].split("="),
                                    r = a.slice(1).join("=");
                                '"' === r[0] && (r = r.slice(1, -1));
                                try {
                                    var l = t.read(a[0]);
                                    if (((o[l] = s.read(r, l)), e === l)) break;
                                } catch (t) {}
                            }
                            return e ? o[e] : o;
                        }
                    },
                    remove: function (t, i) {
                        n(t, "", e({}, i, { expires: -1 }));
                    },
                    withAttributes: function (t) {
                        return i(this.converter, e({}, this.attributes, t));
                    },
                    withConverter: function (t) {
                        return i(e({}, this.converter, t), this.attributes);
                    },
                },
                { attributes: { value: Object.freeze(o) }, converter: { value: Object.freeze(s) } }
            );
        })(t, { path: "/" });
    }),
    $(function () {
        $(".switch_lang").on("click", function () {
            $.post("https://www.cmuccdc.org/main/switch_lang", { lang: $(this).attr("lang"), url: $(this).attr("redirect") }, function (t) {
                location.reload();
            });
        }),
            $(".switch_type").on("click", function () {
                $.post("https://www.cmuccdc.org/main/switch_type", { sType: $(this).attr("sType"), url: $(this).attr("redirect") }, function (t) {
                    location.reload();
                });
            }),
            $("#btn-hourly-filter").on("click", function () {
                var t = $("#select-hourly-filter").val();
                t ? (document.location.href = "/hourly/" + t) : alert("กรุณาเลือกจังหวัดเพื่อดูข้อมูล ค่าฝุ่นรายชั่วโมง");
            }),
            $("#btn-daily-filter").on("click", function () {
                var t = $("#select-daily-filter").val();
                t ? (document.location.href = "/daily/" + t) : alert("กรุณาเลือกจังหวัดเพื่อดูข้อมูล ค่าฝุ่นรายวัน");
            }),
            $("#news-page-news-feed .news-slice").slice(0, 6).show(),
            $(".news-see-more-btn").on("click", function (t) {
                t.preventDefault(), $("#news-page-news-feed .news-slice:hidden").slice(0, 6).slideDown(), 0 === $("#news-page-news-feed .news-slice:hidden").length && $(".news-see-more-btn").addClass("disabled btn");
            }),
            $("#research_feed .research_list").slice(0, 6).show(),
            $(".research_more").on("click", function (t) {
                t.preventDefault(), $("#research_feed .research_list:hidden").slice(0, 6).slideDown(), 0 === $("#research_feed .research_list:hidden").length && $(".research_more").addClass("disabled btn");
            }),
            $(".ccdc_content").find("iframe").wrap('<div class="embed-responsive embed-responsive-16by9"/>'),
            $(".ccdc_content").find("iframe").addClass("embed-responsive-item"),
            $(".btn-close").on("click", function () {
                $(".card").hide();
            }),
            $("#btn_contact").on("click", function () {
                $(this).toggleClass("open"),
                    $(this).is(".open")
                        ? ($("#main").addClass("fade_out"),
                          $("#main").removeClass("fade_in"),
                          $("#contact").removeClass("fade_out"),
                          $("#contact").addClass("fade_in"),
                          $("footer").addClass("fade_out"),
                          $("footer").removeClass("fade_in"),
                          $("#menu_slide").length <= 0 && ($("#menu_slide").removeClass("out_slide"), $("#menu_slide").hide()),
                          $(".content").length > 0 && ($("#main").hide(), $("#contact").show()),
                          $(window).width() <= 575.98 && $(".content").length <= 0 && $("body").css("overflow", "auto"),
                          $(window).scrollTop() >= 115 && ($("#menu_slide").addClass("out_slide"), $("#menu_slide").removeClass("in_slide"), $("#btn_contact").addClass("out_slide_btn"), $("#btn_contact").removeClass("in_slide_btn")))
                        : $(this).is(".open") ||
                          ($("#contact").addClass("fade_out"),
                          $("#contact").removeClass("fade_in"),
                          $("#main").removeClass("fade_out"),
                          $("#main").addClass("fade_in"),
                          $("footer").removeClass("fade_out"),
                          $("footer").addClass("fade_in"),
                          $("#menu_slide").length <= 0 && ($("#menu_slide").addClass("frist"), $("#menu_slide").show()),
                          $(".content").length > 0 && ($("#main").show(), $("#contact").hide()),
                          $(window).width() <= 575.98 && $(".content").length <= 0 && $("body").css("overflow", "hidden"),
                          $(window).scrollTop() >= 115 && ($("#menu_slide").addClass("in_slide"), $("#menu_slide").removeClass("out_slide"), $("#btn_contact").addClass("in_slide_btn"), $("#btn_contact").removeClass("out_slide_btn")));
            }),
            $(window).scrollTop() >= 115
                ? ($("#menu_slide").is(".frist") && $("#menu_slide").removeClass("frist"),
                  $("#btn_contact").is(".open") || ($("#menu_slide").addClass("in_slide"), $("#menu_slide").removeClass("out_slide"), $("#btn_contact").addClass("in_slide_btn"), $("#btn_contact").removeClass("out_slide_btn")))
                : ($("#btn_contact").is(".open") && ($("#menu_slide").removeClass("in_slide"), $("#btn_contact").removeClass("in_slide_btn")),
                  $("#menu_slide").is(".frist") ||
                      $("#btn_contact").is(".open") ||
                      ($("#menu_slide").addClass("out_slide"), $("#menu_slide").removeClass("in_slide"), $("#btn_contact").addClass("out_slide_btn"), $("#btn_contact").removeClass("in_slide_btn"))),
            $(window).scroll(function () {
                var t = $(window).scrollTop();
                $(window).width() > 992 &&
                    (t >= 115
                        ? ($("#menu_slide").is(".frist") && $("#menu_slide").removeClass("frist"),
                          $("#btn_contact").is(".open") || ($("#menu_slide").addClass("in_slide"), $("#menu_slide").removeClass("out_slide"), $("#btn_contact").addClass("in_slide_btn"), $("#btn_contact").removeClass("out_slide_btn")))
                        : ($("#btn_contact").is(".open") && ($("#menu_slide").removeClass("in_slide"), $("#btn_contact").removeClass("in_slide_btn")),
                          $("#menu_slide").is(".frist") ||
                              $("#btn_contact").is(".open") ||
                              ($("#menu_slide").addClass("out_slide"), $("#menu_slide").removeClass("in_slide"), $("#btn_contact").addClass("out_slide_btn"), $("#btn_contact").removeClass("in_slide_btn"))));
            });
    });
var osmUrl = "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",
    osmAttrib = 'Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors',
    opacity = 1,
    OpenStreetMap = new L.tileLayer(osmUrl, { maxZoom: 18, attribution: osmAttrib, opacity: opacity }),
    Topographic = new L.esri.basemapLayer("Topographic", { opacity: opacity }),
    Streets = new L.esri.basemapLayer("Streets", { opacity: opacity }),
    NationalGeographic = new L.esri.basemapLayer("NationalGeographic", { opacity: opacity }),
    Oceans = new L.esri.basemapLayer("Oceans", { opacity: opacity }),
    Gray = new L.esri.basemapLayer("Gray", { opacity: opacity }),
    DarkGray = new L.esri.basemapLayer("DarkGray"),
    Imagery = new L.esri.basemapLayer("Imagery"),
    ShadedRelief = new L.esri.basemapLayer("ShadedRelief", { opacity: opacity }),
    startTimeGFS = new Date(Date.UTC(GFS_server_year, GFS_server_month - 1, GFS_server_day, GFS_server_hour)),
    actualTimeGFS = new Date(Date.UTC(GFS_server_year, GFS_server_month - 1, GFS_server_day, GFS_server_hour + 6)),
    endTimeGFS = new Date(Date.UTC(GFS_server_year, GFS_server_month - 1, GFS_server_day, GFS_server_hour + (GFS_timesteps - 1) * GFS_interval)),
    dataTimeIntervalGFS = startTimeGFS.toISOString() + "/" + endTimeGFS.toISOString(),
    actualIntervalGFS = 2 * GFS_interval,
    baseIndexGFS = 1,
    dataPeriodGFS = "PT" + actualIntervalGFS + "H",
    wind10mBaseURL = "/weather/wind10m/",
    wind10mBaseName = "wind10m_{h}h",
    wind10mName = "",
    wind10mArray = [],
    startTimeRTOFS = new Date(Date.UTC(RTOFS_server_year, RTOFS_server_month - 1, RTOFS_server_day, RTOFS_server_hour)),
    actualTimeRTOFS = new Date(Date.UTC(RTOFS_server_year, RTOFS_server_month - 1, RTOFS_server_day, RTOFS_server_hour + 6)),
    endTimeRTOFS = new Date(Date.UTC(RTOFS_server_year, RTOFS_server_month - 1, RTOFS_server_day, RTOFS_server_hour + (RTOFS_timesteps - 1) * RTOFS_interval)),
    dataTimeIntervalRTOFS = startTimeRTOFS.toISOString() + "/" + endTimeRTOFS.toISOString(),
    actualIntervalRTOFS = 2 * RTOFS_interval,
    baseIndexRTOFS = 1,
    dataPeriodRTOFS = "PT" + actualIntervalRTOFS + "H",
    seaSurfaceCurrentBaseURL = "weather/sea_surface_current/",
    seaSurfaceCurrentBaseName = "sea_surface_current_{h}h",
    seaSurfaceCurrentName = "",
    seaSurfaceCurrentArray = [];
let actualModel,
    startTime,
    actualTime,
    endTime,
    dataTimeInterval,
    actualInterval,
    baseIndex,
    dataPeriod,
    actualLayerBaseURL,
    actualLayerBaseName,
    angleConventionValue,
    speedUnitValue,
    colorScale,
    initDisplayValues,
    initVelocityType,
    initEmptyString,
    initAngleConvention,
    initSpeedUnit,
    initMinVelocity,
    initMaxVelocity,
    initVelocityScale,
    initParticleAge,
    initLineWidth,
    initParticleMultiplier,
    initFrameRate,
    initColorScale,
    actualLayer = "Wind",
    actualLayerName = "",
    actualLayerArray = [],
    parameter = "wind10m",
    displayValues = document.getElementById("displayValues");
displayValues.addEventListener("change", function () {
    updateLayer(actualLayerArray[actualTimeIndex]);
}),
    switchParameter(actualLayer);
var map = new L.map("us_map", {
        center: [13.912, 100.5270061],
        zoom: 5,
        attributionControl: !1,
        maxZoom: 17,
        minZoom: 5,
        fullscreenControl: !0,
        fullscreenControlOptions: { position: "topleft" },
        layers: [OpenStreetMap],
        timeDimension: !0,
        timeDimensionOptions: { timeInterval: dataTimeInterval, period: dataPeriod, currentTime: actualTime },
        timeDimensionControl: !1,
        timeDimensionControlOptions: { loopButton: !1, speedStep: 0.1, minSpeed: 0.2, maxSpeed: 0.3, limitSliders: !1, limitMinimumRange: 24 / GFS_interval, playButton: !1, speedSlider: !1 },
    }),
    lc = L.control.locate({ position: "topleft", strings: { title: "Show My Location" } }).addTo(map),
    baseMaps = { OpenStreetMap: OpenStreetMap, Streets: Streets, Imagery: Imagery },
    layerControl = new L.control.layers(baseMaps);
layerControl.addTo(map);
var actualLayerGroup = new L.layerGroup([], {}),
    actualLayerGroup2 = new L.layerGroup([], {});
actualLayerArray.length = map.timeDimension._availableTimes.length;
var actualTimeIndex = map.timeDimension._currentTimeIndex;
function initializeLayer(t) {
    actualLayerGroup.clearLayers(),
        (actualLayerName = actualLayerBaseName.replace(/{h}/g, (actualTimeIndex - baseIndex) * actualInterval)),
        (actualLayerName = "wind10m_0h"),
        (document.getElementById("displayValues").checked = initDisplayValues),
        $.getJSON(actualLayerBaseURL + actualLayerName + ".json", function (t) {
            (this[actualLayerName] = L.velocityLayer({
                displayValues: document.getElementById("displayValues").checked,
                displayOptions: { velocityType: "Wind", emptyString: "No wind data", angleConvention: "meteoCW", speedUnit: "km/h" },
                data: t,
                minVelocity: parseFloat(5),
                maxVelocity: parseFloat(30),
                velocityScale: parseFloat(0.009),
                particleAge: parseInt(90),
                lineWidth: parseInt(1),
                particleMultiplier: parseFloat(0.0053),
                frameRate: parseInt(15),
            })),
                actualLayerGroup.addLayer(this[actualLayerName]),
                (actualLayerArray[actualTimeIndex] = actualLayerGroup.getLayer(actualLayerGroup.getLayerId(this[actualLayerName]))),
                actualLayerGroup.addTo(map);
        });
}
function updateLayer(t) {
    (map.timeDimension.options.timeInterval = dataTimeInterval),
        (map.timeDimension.options.period = dataPeriod),
        (map.timeDimension.options.currentTime = actualTime),
        actualLayerGroup.clearLayers(),
        (actualLayerName = actualLayerBaseName.replace(/{h}/g, (actualTimeIndex - baseIndex) * actualInterval)),
        (actualLayerName = "wind10m_0h"),
        $.getJSON(actualLayerBaseURL + actualLayerName + ".json", function (t) {
            (this[actualLayerName] = L.velocityLayer({
                displayValues: document.getElementById("displayValues").checked,
                displayOptions: { velocityType: "Wind", emptyString: "No wind data", angleConvention: "meteoCW", speedUnit: "km/h" },
                data: t,
                minVelocity: parseFloat(5),
                maxVelocity: parseFloat(30),
                velocityScale: parseFloat(0.009),
                particleAge: parseInt(90),
                lineWidth: parseInt(1),
                particleMultiplier: parseFloat(0.0053),
                frameRate: parseInt(15),
            })),
                actualLayerGroup.addLayer(this[actualLayerName]),
                (actualLayerArray[actualTimeIndex] = actualLayerGroup.getLayer(actualLayerGroup.getLayerId(this[actualLayerName]))),
                actualLayerGroup.addTo(map);
        });
}
function createVmap(t) {
    actualLayerGroup2.clearLayers();
    fetch(t)
        .then((t) => t.arrayBuffer())
        .then((t) => {
            parseGeoraster(t).then((t) => {
                var e = new GeoRasterLayer({ georaster: t, opacity: 0.9, resolution: 256 });
                e.addTo(map), map.fitBounds(e.getBounds()), actualLayerGroup2.addLayer(e), actualLayerGroup2.addTo(map);
            });
        });
}
function switchParameter(t) {
    switch (t) {
        case "Wind":
            (actualModel = "GFS"),
                (actualLayerBaseURL = wind10mBaseURL),
                (actualLayerBaseName = wind10mBaseName),
                (initDisplayValues = !0),
                (initVelocityType = "Wind"),
                (initEmptyString = "No wind data"),
                (initAngleConvention = "bearingCW"),
                (initSpeedUnit = "Bft"),
                (initMinVelocity = 0),
                (initMaxVelocity = 30),
                (initVelocityScale = 0.001),
                (initParticleAge = 90),
                (initLineWidth = 1),
                (initParticleMultiplier = 0.0033),
                (initFrameRate = 15),
                (initColorScale = ["#2468b4", "#3c9dc2", "#80cdc1", "#97daa8", "#c6e7b5", "#eef7d9", "#ffee9f", "#fcd97d", "#ffb664", "#fc964b", "#fa7034", "#f54020", "#ed2d1c", "#dc1820", "#b40023"]);
    }
}

	var type =Cookies.get("data_index");
	if(type=="th-hr" || type=="th-dy"){
		var usevmap = vmap;
	}else{
		var usevmap = vmap_us;
	}
layerControl.addOverlay(actualLayerGroup, actualLayer),
    layerControl.addOverlay(actualLayerGroup2, "VMap"),
    createVmap(usevmap),
    initializeLayer(actualLayerArray[actualTimeIndex]),
    window.setInterval(function () {
        actualTimeIndex != map.timeDimension._currentTimeIndex && ((actualTimeIndex = map.timeDimension._currentTimeIndex), updateLayer(actualLayerArray[actualTimeIndex]));
    }, 100),
    $(".switch_type2").on("click", function () {
        $("#sw_source").html($(this).html()), $(".switch_type2").removeClass("active"), $(this).addClass("active"), Cookies.set("data_index", $(this).attr("data_index")), location.reload();
    });
var data_type = Cookies.get("data_index");
$.getJSON("https://www.cmuccdc.org/assets/api/standard_aqi.json", function (t) {
    for (var e = t[0].us_aqi, i = t[0].th_aqi, s = "", o = "", n = "", a = "", r = "", l = "", h = 0; h < e.pm25.length; ++h)
        (r += '<div class="col col-md-1 detail_pm_aqi" style="background-color: rgb(' + e.aqi[h].color + ');"><img width="20" src="/template/image/' + e.aqi[h].dustboy_icon + '"></div>'),
            h == e.pm25.length - 1
                ? ((s += '<div class="col col-md-1 detail_pm_aqi" style="background-color: rgb(' + e.pm25[h].color + ');">>' + e.pm25[h - 1].max + "</div>"),
                  (l += '<div class="col col-md-1 detail_pm_aqi" style="background-color: rgb(' + e.aqi[h].color + ');">>' + e.aqi[h - 1].max + "</div>"))
                : ((l += '<div class="col col-md-1 detail_pm_aqi" style="background-color: rgb(' + e.aqi[h].color + ');">' + e.aqi[h].min + "-" + e.aqi[h].max + "</div>"),
                  (s += '<div class="col col-md-1 detail_pm_aqi" style="background-color: rgb(' + e.pm25[h].color + ');">' + e.pm25[h].min + "-" + e.pm25[h].max + "</div>"));
    for (h = 0; h < i.pm25.length; ++h)
        (n += '<div class="col col-md-1 detail_pm_aqi" style="background-color: rgb(' + i.aqi[h].color + ');"><img width="20" src="/template/image/' + i.aqi[h].dustboy_icon + '"></div>'),
            h == i.pm25.length - 1
                ? ((o += '<div class="col col-md-1 detail_pm_aqi" style="background-color: rgb(' + i.pm25[h].color + ');">>' + i.pm25[h - 1].max + "</div>"),
                  (a += '<div class="col col-md-1 detail_pm_aqi" style="background-color: rgb(' + i.aqi[h].color + ');">>' + i.aqi[h - 1].max + "</div>"))
                : ((a += '<div class="col col-md-1 detail_pm_aqi" style="background-color: rgb(' + i.aqi[h].color + ');">' + i.aqi[h].min + "-" + i.aqi[h].max + "</div>"),
                  (o += '<div class="col col-md-1 detail_pm_aqi" style="background-color: rgb(' + i.pm25[h].color + ');">' + i.pm25[h].min + "-" + i.pm25[h].max + "</div>"));
    var c = '<div class="pm_aqi">';
    (c += '<div class="pm fade_in_ture anime_delay1">'),
        (c += '<div class="col col-md-6 title_pm_aqi ">PM<sub>2.5</sub><span class="d-none d-md-block">(μg/m<sup>3</sup>)</span></div>'),
        (c += s),
        (c += "</div>"),
        (c += '<div class="aqi fade_in_ture anime_delay15">'),
        (c += '<div class="col col-md-6 title_pm_aqi "></div>'),
        (c += r),
        (c += "</div>"),
        (c += "</div>");
    var p = '<div class="pm_aqi">';
    (p += '<div class="pm fade_in_ture anime_delay1">'),
        (p += '<div class="col col-md-6 title_pm_aqi ">PM<sub>2.5</sub><span class="d-none d-md-block">(μg/m<sup>3</sup>)</span></div>'),
        (p += s),
        (p += "</div>"),
        (p += '<div class="aqi fade_in_ture anime_delay15">'),
        (p += '<div class="col col-md-6 title_pm_aqi ">US AQI</div>'),
        (p += l),
        (p += "</div>"),
        (p += "</div>");
    var d = '<div class="pm_aqi">';
    (d += '<div class="pm fade_in_ture anime_delay1">'),
        (d += '<div class="col col-md-7 title_pm_aqi ">PM<sub>2.5</sub><span class="d-none d-md-block">(μg/m<sup>3</sup>)</span></div>'),
        (d += o),
        (d += "</div>"),
        (d += '<div class="aqi fade_in_ture anime_delay15">'),
        (d += '<div class="col col-md-7 title_pm_aqi "></div>'),
        (d += n),
        (d += "</div>"),
        (d += "</div>");
    var u = '<div class="pm_aqi">';
    (u += '<div class="pm fade_in_ture anime_delay1">'),
        (u += '<div class="col col-md-7 title_pm_aqi ">PM<sub>2.5</sub><span class="d-none d-md-block">(μg/m<sup>3</sup>)</span></div>'),
        (u += o),
        (u += "</div>"),
        (u += '<div class="aqi fade_in_ture anime_delay15">'),
        (u += '<div class="col col-md-7 title_pm_aqi ">TH AQI</div>'),
        (u += a),
        (u += "</div>"),
        (u += "</div>"),
        $("#th_index").html(d),
        $("#th_index_daily").html(u),
        $("#us_index").html(c),
        $("#us_index_daily").html(p);
}),
    $.getJSON("https://www.cmuccdc.org/assets/api/genDustboyGeo.php?token=" + token + "&dataType=" + data_type, function (t) {
        if (t) {
            var e = 0;
            geojsonOpts = {
                pointToLayer: function (t, i) {
                    return (
                        0 == e && $("#data-timer").html(convertAVGDateFormat(t.properties.log_datetime)),
                        e++,
                        "th-hr" == data_type
                            ? (marker = L.marker(i, {
                                  icon: L.divIcon({
                                      className: "my-custom-pin",
                                      iconSize: [35, 35],
                                      html: '<div class="signoutz-marker"style="background-color:rgba(' + t.properties.th_color + ', 1)">' + parseInt(t.properties.pm25).toFixed() + "</div>",
                                  }),
                              }).on("click", function (e) {
                                  "thailand" == data_lang ? $("#popupDetail p").html(t.properties.dustboy_name) : $("#popupDetail p").html(t.properties.dustboy_name_en),
                                      $("#popupDetail .card-header").css("background-color", "rgba(" + t.properties.th_color + ", 1)"),
                                      $("#popupDetail .card-body").css("background-color", "rgba(" + t.properties.th_color + ", 1)"),
                                      $("#popupDetail .card-footer").css("background-color", "rgba(" + t.properties.th_color + ", 1)"),
                                      $("#popupDetail .number_title").html(parseInt(t.properties.pm25).toFixed()),
                                      $("#popupDetail .number_footer").html("PM<sub>2.5</sub> (μg/m<sup>3</sup>)"),
                                      "thailand" == data_lang ? $("#popupDetail .detail_title").html(t.properties.th_title) : $("#popupDetail .detail_title").html(t.properties.th_title_en),
                                      $("#popupDetail .card-body .anime img").attr("src", "/template/image/" + t.properties.th_dustboy_icon + ".svg"),
                                      $("#popupDetail .card-footer .weahter").html(convertDateFormatDay(t.properties.log_datetime) + " | " + convertDateFormatHour(t.properties.log_datetime)),
                                      $("#popupDetail .card-footer .favorite").html('<a href="/' + t.properties.dustboy_uri + '" style="color:#fff;"><i class="fa fa-info-circle"></i></a>'),
                                      $("#popupDetail").show();
                              }))
                            : "us-hr" == data_type
                            ? (marker = L.marker(i, {
                                  icon: L.divIcon({
                                      className: "my-custom-pin",
                                      iconSize: [35, 35],
                                      html: '<div class="signoutz-marker"style="background-color:rgba(' + t.properties.us_color + ', 1)">' + parseInt(t.properties.pm25).toFixed() + "</div>",
                                  }),
                              }).on("click", function (e) {
                                  "thailand" == data_lang ? $("#popupDetail p").html(t.properties.dustboy_name) : $("#popupDetail p").html(t.properties.dustboy_name_en),
                                      $("#popupDetail .card-header").css("background-color", "rgba(" + t.properties.us_color + ", 1)"),
                                      $("#popupDetail .card-body").css("background-color", "rgba(" + t.properties.us_color + ", 1)"),
                                      $("#popupDetail .card-footer").css("background-color", "rgba(" + t.properties.us_color + ", 1)"),
                                      $("#popupDetail .number_title").html(parseInt(t.properties.pm25).toFixed()),
                                      $("#popupDetail .number_footer").html("μg/m<sup>3</sup>"),
                                      "thailand" == data_lang ? $("#popupDetail .detail_title").html(t.properties.us_title) : $("#popupDetail .detail_title").html(t.properties.us_title_en),
                                      $("#popupDetail .card-body .anime img").attr("src", "/template/image/" + t.properties.us_dustboy_icon + ".svg"),
                                      $("#popupDetail .card-footer .weahter").html(convertDateFormatDay(t.properties.log_datetime) + " | " + convertDateFormatHour(t.properties.log_datetime)),
                                      $("#popupDetail .card-footer .favorite").html('<a href="/' + t.properties.dustboy_uri + '" style="color:#fff;"><i class="fa fa-info-circle"></i></a>'),
                                      $("#popupDetail").show();
                              }))
                            : "th-dy" == data_type
                            ? (marker = L.marker(i, {
                                  icon: L.divIcon({
                                      className: "my-custom-pin",
                                      iconSize: [35, 35],
                                      html: '<div class="signoutz-marker"style="background-color:rgba(' + t.properties.daily_th_color + ', 1)">' + parseInt(t.properties.daily_pm25).toFixed() + "</div>",
                                  }),
                              }).on("click", function (e) {
                                  "thailand" == data_lang ? $("#popupDetail p").html(t.properties.dustboy_name) : $("#popupDetail p").html(t.properties.dustboy_name_en),
                                      $("#popupDetail .card-header").css("background-color", "rgba(" + t.properties.daily_th_color + ", 1)"),
                                      $("#popupDetail .card-body").css("background-color", "rgba(" + t.properties.daily_th_color + ", 1)"),
                                      $("#popupDetail .card-footer").css("background-color", "rgba(" + t.properties.daily_th_color + ", 1)"),
                                      $("#popupDetail .number_title").html(parseInt(t.properties.daily_pm25).toFixed()),
                                      $("#popupDetail .number_footer").html("PM<sub>2.5</sub> (μg/m<sup>3</sup>)"),
                                      "thailand" == data_lang ? $("#popupDetail .detail_title").html(t.properties.daily_th_title) : $("#popupDetail .detail_title").html(t.properties.daily_th_title_en),
                                      $("#popupDetail .card-body .anime img").attr("src", "/template/image/" + t.properties.daily_th_dustboy_icon + ".svg"),
                                      $("#popupDetail .card-footer .weahter").html(convertDateFormat(t.properties.log_datetime) + " | PM<sub>2.5</sub> AQI " + t.properties.daily_pm25_th_aqi),
                                      $("#popupDetail .card-footer .favorite").html('<a href="/' + t.properties.dustboy_uri + '" style="color:#fff;"><i class="fa fa-info-circle"></i></a>'),
                                      $("#popupDetail").show();
                              }))
                            : "us-dy" == data_type
                            ? (marker = L.marker(i, {
                                  icon: L.divIcon({
                                      className: "my-custom-pin",
                                      iconSize: [35, 35],
                                      html: '<div class="signoutz-marker"style="background-color:rgba(' + t.properties.daily_us_color + ', 1)">' + parseInt(t.properties.daily_pm25).toFixed() + "</div>",
                                  }),
                              }).on("click", function (e) {
                                  "thailand" == data_lang ? $("#popupDetail p").html(t.properties.dustboy_name) : $("#popupDetail p").html(t.properties.dustboy_name_en),
                                      $("#popupDetail .card-header").css("background-color", "rgba(" + t.properties.daily_us_color + ", 1)"),
                                      $("#popupDetail .card-body").css("background-color", "rgba(" + t.properties.daily_us_color + ", 1)"),
                                      $("#popupDetail .card-footer").css("background-color", "rgba(" + t.properties.daily_us_color + ", 1)"),
                                      $("#popupDetail .number_title").html(parseInt(t.properties.daily_pm25).toFixed()),
                                      $("#popupDetail .number_footer").html("μg/m<sup>3</sup>"),
                                      "thailand" == data_lang ? $("#popupDetail .detail_title").html(t.properties.daily_us_title) : $("#popupDetail .detail_title").html(t.properties.daily_us_title_en),
                                      $("#popupDetail .card-body .anime img").attr("src", "/template/image/" + t.properties.daily_us_dustboy_icon + ".svg"),
                                      $("#popupDetail .card-footer .weahter").html(convertDateFormat(t.properties.log_datetime) + " | PM<sub>2.5</sub> AQI " + t.properties.daily_pm25_us_aqi),
                                      $("#popupDetail .card-footer .favorite").html('<a href="/' + t.properties.dustboy_uri + '" style="color:#fff;"><i class="fa fa-info-circle"></i></a>'),
                                      $("#popupDetail").show();
                              }))
                            : void 0
                    );
                },
            };
            var i = L.layerGroup([L.geoJson(t, geojsonOpts)]).addTo(map);
            L.control
                .search({
                    position: "topright",
                    layer: i,
                    initial: !1,
                    propertyName: "dustboy_name",
                    zoom: 13,
                    buildTip: function (t, e) {
                        return '<a href="#">' + t + "</a>";
                    },
                })
                .addTo(map);
            layerControl.addOverlay(i, "DustBoy");
        }
    });
