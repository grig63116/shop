const utils = {
    strReplaceAll (str, search, replacement) {
        str = this.toString(str);
        return str.replace(new RegExp(search, 'g'), replacement);
    },
    toString (p) {
        return this.isStr(p) || this.isNum(p) ? p.toString() : '';
    },
    isStr (p) {
        return p && p.constructor.prototype === String.prototype;
    },
    isNum (p) {
        return p && p.constructor.prototype === Number.prototype && !this.isNaN(p);
    },
    isNaN (p) {
        return Number.isNaN(p);
    }
}

export default utils
