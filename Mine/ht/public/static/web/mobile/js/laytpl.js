

;!function () {
    "use strict";
    var f, b = {open: "{{", close: "}}"}, c = {
        exp: function (a) {
            return new RegExp(a, "g")
        }, query: function (a, c, e) {
            var f = ["#([\\s\\S])+?", "([^{#}])*?"][a || 0];
            return d((c || "") + b.open + f + b.close + (e || ""))
        }, escape: function (a) {
            return String(a || "").replace(/&(?!#?[a-zA-Z0-9]+;)/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/'/g, "&#39;").replace(/"/g, "&quot;")
        }, error: function (a, b) {
            var c = "Laytpl Error锛�";
            return "object" == typeof console && console.error(c + a + "\n" + (b || "")), c + a
        }
    }, d = c.exp, e = function (a) {
        this.tpl = a
    };
    e.pt = e.prototype, e.pt.parse = function (a, e) {
        var f = this, g = a, h = d("^" + b.open + "#", ""), i = d(b.close + "$", "");
        a = a.replace(/[\r\t\n]/g, " ").replace(d(b.open + "#"), b.open + "# ").replace(d(b.close + "}"), "} " + b.close).replace(/\\/g, "\\\\").replace(/(?="|')/g, "\\").replace(c.query(), function (a) {
            return a = a.replace(h, "").replace(i, ""), '";' + a.replace(/\\/g, "") + '; view+="'
        }).replace(c.query(1), function (a) {
            var c = '"+(';
            return a.replace(/\s/g, "") === b.open + b.close ? "" : (a = a.replace(d(b.open + "|" + b.close), ""), /^=/.test(a) && (a = a.replace(/^=/, ""), c = '"+_escape_('), c + a.replace(/\\/g, "") + ')+"')
        }), a = '"use strict";var view = "' + a + '";return view;';
        try {
            return f.cache = a = new Function("d, _escape_", a), a(e, c.escape)
        } catch (j) {
            return delete f.cache, c.error(j, g)
        }
    }, e.pt.render = function (a, b) {
        var e, d = this;
        return a ? (e = d.cache ? d.cache(a, c.escape) : d.parse(d.tpl, a), b ? (b(e), void 0) : e) : c.error("no data")
    }, f = function (a) {
        return "string" != typeof a ? c.error("Template not found") : new e(a)
    }, f.config = function (a) {
        a = a || {};
        for (var c in a) b[c] = a[c]
    }, f.v = "1.1", "function" == typeof define ? define(function () {
        return f
    }) : "undefined" != typeof exports ? module.exports = f : window.laytpl = f
}();