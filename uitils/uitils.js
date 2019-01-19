/**
 * [此文件是封装本项目公共的工具]
 * @type {Object}  调用直接引用此文件,然后 例子: uitils.converToObj(参数);
 */
var uitils={
	/**
	 * 封装将从地址栏获取到 ? 后面的字符串转为对象的函数
	 * @author lucky
	 * @DateTime 2018-10-11T19:01:08+0800
	 * @param    {[type]}                 str [传入获取到的字符串]
	 * @return   {[type]}                 obj [将转换成功后的对象返回]
	 */
	converToObj:function(str){
		//1. 截取 ? 后面的字符串  substring(from, to) 方法从 from 位置截取到 to 位置，to 可选，没有设置时默认到末尾。
		str=str.substring(1);		// id=3&name=tom&age=20
		// console.log(str)  
		//2. 第一次切割  去掉 & 符号  split('需要去掉的符号'),返回一个数组
		var arr=str.split('&');
		//4. 循环遍历数组,再次切割遍历到的每个数组
		var obj={};  //定义空对象用于存储切割后的数据
		for(var i=0;i<arr.length;i++){
			var temp=arr[i].split('=');   // ["id", "6"]  ["name", "tom"]  ["age", "20"]
			//将数据追加到对象中
			obj[temp[0]]=temp[1];   // {id: "3", name: "tom", age: "20"}
		}
		//返回值
		return obj;
	}
}