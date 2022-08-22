<template>
	<view class="index">
		<header>
			<swiper class="swiper" :indicator-dots="swiper.dots" :autoplay="swiper.autopaly" :interval="swiper.interval" :duration="swiper.duration" circular>
				<swiper-item v-for="(item,index) in show_list" :key='index'> 
					<view class="swiper-item">
						<image :src="item" mode=""></image>
					</view>
				</swiper-item>
			</swiper>
		</header>
		<main>
			<button type="primary" @click="setShow">设置展示图</button>
			<!-- <button type="default" @click="show" class="topPx">查看展示图</button> -->
			<button type="default" @click="exitLogin" class="topPx">退出登录</button>
		</main>
	</view>
</template>

<script>
	let that;
	import {pathToBase64} from'../../js_sdk/mmmm-image-tools/index.js'
	export default {
		data() {
			return {
				swiper:{
					dots:true,
					autopaly:true,
					interval:3000,
					duration:1000,
				},
				show_list:[],
				user:null,
				pnumber:0,
			}
		},
		onReady() {
			this.$myfuns.setBarTitle("首页");
		},
		onLoad() {
			that = this;
		},
		mounted() {
			uni.getStorage({
				key:'account',
				success(res){
					that.user = res.data;
					that.getPicture();
					// that.show();
				}
			});
		},
		methods: {
			setShow(){
				uni.chooseImage({
					count: 3, //默认9
					sizeType: ['original', 'compressed'], //可以指定是原图还是压缩图，默认二者都有
					sourceType: ['album'], //从相册选择
					success: function (res) {
						that.pnumber = res.tempFilePaths.length;
						console.log(that.pnumber);
						let arr = [];
						for(let i=0;i<res.tempFilePaths.length;i++){
							uni.uploadFile({
								url: 'http://192.168.31.51:8055/jzq/php/index/uploadimg.php',
								filePath: res.tempFilePaths[i],
								name: 'file',
								formData: {
									'user': that.user,
									'pid':i,
								},
								success: (uploadFileRes) => {
									arr[i] = res.tempFilePaths[i];
									console.log(uploadFileRes.data);
									if(i==res.tempFilePaths.length-1){
										console.log(i,'break',arr);
										that.getPicture();
										return;
									}
								}
							});
						}
					}
				});
			},
			getPicture(){
				that.$myfuns.myRequest({
					url:'index/getPicture.php',
					data:{
						user:that.user,
					}
				}).then(res=>{
					console.log(res);
					let purl = res.data.data[0].user_show;
					console.log(purl);
					let before = '../../static/show/';
					let geturl = -1;
					let surplus = -1;
					if(that.pnumber==0){
						that.pnumber=3;
					}
					console.log(that.pnumber);
					let arr = [];
					for(let i=0;i<that.pnumber;i++){
						if(surplus==-1){
							let index = purl.indexOf(";");
							console.log(index);
							geturl = purl.slice(0,index);
							surplus = purl.slice(index+1);
						}else{
							let index = surplus.indexOf(';');
							geturl = surplus.slice(0,index);
							surplus = surplus.slice(index+1);
						}
						arr[i]= before + geturl;
					}
					uni.setStorage({
						key:'pictureList',
						data:arr,
					})
					that.show();
				})
			},
			show(){
				uni.getStorage({
					key:'pictureList',
					success(res){
						console.log(res.data);
						that.show_list = res.data;
					}
				})
			},
			exitLogin(){
				uni.redirectTo({
					url:'../login/login',
					success() {
						uni.clearStorage();
					}
				})
			},
		}
	}
</script>

<style scoped>
	.index .swiper{
		height: 300px;
	}
	.swiper-item image{
		width: 100%;
		height: 300px;
	}
	.index main{
		margin-top: 100px;
	}
	.topPx{
		margin-top: 20px;
	}
</style>
