//本文地址：http://zhupeixin.top/article/2018/01/merge-json
var objC = {}.constructor;
function isObj(obj) {
    return !!(obj && obj.constructor === objC);
}

var arrC = [].constructor;
var isArr = function (arr) {
    return !!(arr && arr.constructor === arrC);
}


