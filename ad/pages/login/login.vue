<template>
	<view class="login">
		<!-- 自适应手机顶部刘海 -->
		<view class="status_bar"></view>
		<!-- 内容区 -->
		<view class="content">
			<!-- 系统icon -->
			<header>
				<text class="iconfont icon-guanggaopai"></text>
			</header>
			<!-- 用户输入区域 -->
			<main>
				<!-- 账号输入框 -->
				<view class="account">
					<text class="iconfont icon-zhanghu"></text>
					<input type="text" v-model="user.account" placeholder="请输入用户账号(电话号码)" @input="checkAccount"/>
					<span class="tips">{{tip.account}}</span>
				</view>
				<!-- 密码输入框 -->
				<view class="password">
					<text class="iconfont icon-mima"></text>
					<input type="password" v-model="user.password" placeholder="请输入用户密码" @input="checkPassword"/>
					<span class="tips">{{tip.password}}</span>
				</view>
			</main>
			<!-- 底部按钮区域 -->
			<footer>
				<button type="primary" @click="toLogin">登录</button>
				<button type="default" @click="toRegister" class="topPx">注册</button>
			</footer>
		</view>
	</view>
</template>

<script>
	let that;
	export default {
		data() {
			return {
				user:{},
				tip:{},
				flag:false,
				timerAccount:null,
				timerPwd:null,
			}
		},
		methods: {
			checkAccount(){
				clearTimeout(this.timerAccount);
				this.tip = {};
				this.timerAccount = setTimeout(()=>{
					if(this.user.account){
						if(this.user.account.length==11){
							// 设置手机号验证正则表达式
							let reg = /^1[3|4|5|7|8][0-9]\d{4,8}$/;
							if(!reg.test(this.user.account)){
								this.$set(this.tip,"account","请输入正确的手机号码");
								this.flag = false;
							}else{
								this.flag = true;
							}
						}else{
							this.$set(this.tip,"account","请输入正确的手机号码");
							this.flag = false;
						}
					}else{
						this.$set(this.tip,"account","手机号不能为空");
						this.flag = false;
					}
				},500);
			},
			checkPassword(){
				clearTimeout(this.timerPwd);
				this.tip = {};
				this.timerPwd = setTimeout(()=>{
					if(this.user.password){
						// time记录不符合规范的次数
						let time = 0;
						// 密码验证正则表达式
						let reg = /[0-9]|[A-z]/;
						for(let i=0;i<this.user.password.length;i++){
							if(!reg.test(this.user.password[i])){
								time = 1;
							}
						}
						if(time == 1){
							this.$set(this.tip,"password","密码只能是数字、英文字符");
							this.flag = false;
						}else{
							this.flag = true;
						}
					}else{
						this.$set(this.tip,"password","密码不能为空");
						this.flag = false;
					}
				},500);
			},
			toLogin(){
				this.checkAccount();
				this.checkPassword();
				console.log(this.flag);
				if(this.flag){
					console.log('in');
					uni.showLoading({
						title:"登录中",
						success() {
							that.$myfuns.myRequest({
								url:'login/login.php',
								data:{
									user:that.user.account,
									pwd:that.user.password,
								}
							}).then(res=>{
								console.log(res);
								let timer1 = setTimeout(()=>{
									uni.hideLoading();
									uni.showToast({
										title:res.data.msg,
										success() {
											let timer = setTimeout(()=>{
												if(res.data.code==1){
													uni.setStorage({
														key:'account',
														data:res.data.data[0].user_account,
													})
													uni.redirectTo({
														url:'../index/index',
													})
												}
											},1300)
										}
									})
								},1000)
							})
						}
					})
				}else{
					console.log('out');
				}
			},
			toRegister(){
				uni.redirectTo({
					url:"../register/register",
				})
			}
		},
		onReady() {
			this.$myfuns.setBarTitle("登录");
		},
		onLoad() {
			that = this;
		}
	}
</script>

<style scoped>
	.status_bar {
		height: var(--status-bar-height);
		width: 100%;
	}
	input{
		border: 1px solid black;
		padding:6px 0px;
		padding-left: 30px;
	}
	.content{
		padding: 20px;
		padding-top: 100px;
	}
	header text{
		display:block;
		text-align: center;
		padding: 20px;
		padding-bottom: 50px;
		font-size: 80px;
	}
	footer{
		padding: 0 70px;
	}
	.account,.password{
		padding: 0px 30px;
		position: relative;
	}
	.tips{
		display: block;
		height: 30px;
		color: red;
	}
	.icon-mima,.icon-zhanghu{
		position: absolute;
		top: 10px;
		padding-left: 10px;
	}
	.topPx{
		margin-top: 20px;
	}
</style>
