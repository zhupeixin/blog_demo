//本文地址：http://zhupeixin.top/article/2018/01/equal-json
var objC = {}.constructor;
function isObj(obj) {
    return !!(obj && obj.constructor === objC);
}

var arrC = [].constructor;
var isArr = function (arr) {
    return !!(arr && arr.constructor === arrC);
};

function compare(obj1, obj2) {
    var flag = true;
    if ((isObj(obj1) && isObj(obj2)) || (isArr(obj1) && isArr(obj2))) {
        if (isArr(obj1) && obj1.length !== obj2.length) return false;
        for (var key in obj1) {
            if (obj1.hasOwnProperty(key)) {
                if (typeof obj1[key] === 'object') {
                    if (!compare(obj1[key], obj2[key]))
                        flag = false;
                } else if (obj1[key] !== obj2[key]) {
                    flag = false;
                }
            }
        }
    } else if (obj1 !== obj2) {
        flag = false;
    }
    return flag;
}

//测试用例
console.log(compare({a:1},{a:1})); //true
console.log(compare({a:[1,2,3]},{a:[1,2,3]})); //true
console.log(compare({a:[1,2,3],b:{bb:[true,null,undefined,'aa',22]}},{a:[1,2,3],b:{bb:[true,null,undefined,'aa',22]}})); //true