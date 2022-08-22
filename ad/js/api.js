// const baseURL = 'http://127.0.0.1:8055/jzq/php/';
const baseURL = 'http://192.168.31.51:8055/jzq/php/'; 
export const myRequest = (options)=>{
	// console.log(options);
	return new Promise((resolve,reject)=>{
		uni.request({
			url: baseURL + options.url,
			method:options.method || 'GET',
			data:options.data || {},
			success:(res)=>{
				resolve(res);
			},
			fail: (err) => {
				uni.showToast({
					title:'请求接口失败!'
				});
				reject(err);
			}
		})
	})
}
// 设置导航栏标题
export const setBarTitle = function(title){
	// console.log(title);
	uni.setNavigationBarTitle({
		title:title,
	})
}
// 验证手机号
export const checkPhone = function(phone,tips){
	console.log(phone);
	if(phone){
		// 设置手机号验证正则表达式
		let reg = /^1[3|4|5|7|8][0-9]\d{4,8}$/;
		if(!reg.test(phone)){
			tips.account = "请输入正确的手机号码";
			return false;
		}else{
			return true;
		}
	}else{
		tips.account = "手机号不能为空";
		return false;
	}
}
// 验证密码
export const checkPwd  = function(pwd,tips){
	console.log(pwd);
	if(pwd){
		// time记录不符合规范的次数
		let time = 0;
		// 密码验证正则表达式
		let reg = /[0-9]|[A-z]/;
		for(let i=0;i<pwd.length;i++){
			if(!reg.test(pwd[i])){
				time = 1;
			}
		}
		if(time == 1){
			tips.pwd = "密码只能是数字、英文字符";
			return false;
		}else{
			return true;
		}
	}else{
		tips.pwd = "密码不能为空";
		return false;
	}
}