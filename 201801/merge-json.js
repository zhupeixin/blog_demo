//本文地址：http://zhupeixin.top/article/2018/01/merge-json
var objC = {}.constructor;
function isJSON(obj) {
    return !!(obj && obj.constructor === objC);
}

var arrC = [].constructor;
function isArr(arr) {
    return !!(arr && arr.constructor === arrC);
}

function merge(json1,json2) {
    var result = null;
    if(isJSON(json2)){
        result = {};
        if(isJSON(json1)){
            for(var key in json1){
                if(json1.hasOwnProperty(key)){
                    result[key] = json1[key];
                }
            }
        }

        for(key in json2){
            if(json2.hasOwnProperty(key)){
                if(typeof result[key] === 'object' && typeof json2[key] === 'object'){
                    result[key] = merge(result[key],json2[key]);
                }else{
                    result[key] = json2[key];
                }
            }
        }
    }else if(isArr(json1) && isArr(json2)){
        result = json1;
        json2.forEach(function (t) {
            if(result.indexOf(t) === -1){
                result.push(t);
            }
        })
    }else{
        result = json2;
    }
    return result;
}

//测试用例
console.log(merge({a:1,b:2},{a:2,c:3}));//{ a: 2, b: 2, c: 3 }
console.log(merge({a:[1,2,3],b:2},{a:[1,2,4],c:3}));//{ a: [ 1, 2, 3, 4 ], b: 2, c: 3 }
console.log(merge([1,2,3,4],[1,3,5,6,7,8,9]));//[ 1, 2, 3, 4, 5, 6, 7, 8, 9 ]
console.log(merge(undefined,{a:[1,2,3]}))//{ a: [ 1, 2, 3 ] }