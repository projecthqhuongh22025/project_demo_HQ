<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
	<base href="../../../../">
	<meta charset="utf-8" />
	<title>Đăng nhập</title>
	<meta name="description" content="Singin page example" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	<link rel="canonical" href="https://keenthemes.com/metronic" />
	<!--begin::Fonts-->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
	<!--end::Fonts-->
	<!--begin::Page Custom Styles(used by this page)-->
	<link href="assets/css/pages/login/login-4.css" rel="stylesheet" type="text/css" />
	<!--end::Page Custom Styles-->
	<!--begin::Global Theme Styles(used by all pages)-->
	<link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
	<link href="assets/plugins/custom/prismjs/prismjs.bundle.css" rel="stylesheet" type="text/css" />
	<link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
	<!--end::Global Theme Styles-->
	<!--begin::Layout Themes(used by all pages)-->
	<!--end::Layout Themes-->
	<link rel="shortcut icon" href="assets/media/logos/favicon.ico" />
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled page-loading">
	<!--begin::Main-->
	<div class="d-flex flex-column flex-root">
		<!--begin::Login-->
		<div class="login login-4 wizard d-flex flex-column flex-lg-row flex-column-fluid">
			<!--begin::Content-->
			<div class="login-container order-2 order-lg-1 d-flex flex-center flex-row-fluid px-7 pt-lg-0 pb-lg-0 pt-4 pb-6 bg-white">
				<!--begin::Wrapper-->
				<div class="login-content d-flex flex-column pt-lg-0 pt-12">
					<!--begin::Logo-->
					<a href="#" class="login-logo pb-xl-20 pb-15">
						<img src="assets/media/logos/logo-4.png" class="max-h-70px" alt="" />
					</a>
					<!--end::Logo-->
					<!--begin::Signin-->
					<div class="login-form">
						<!--begin::Form-->
						<form class="form" id="kt_login_singin_form" action="">
							<!--begin::Form group-->
							<div id="content-login_form">
								<!--begin::Title-->
								<div class="pb-5 pb-lg-15">
									<h3 class="font-weight-bolder text-dark font-size-h2 font-size-h1-lg">Đăng nhập</h3>
									<div class="text-muted font-weight-bold font-size-h4">Bạn chưa có tài khoản ?
										<a href="/sign-up" class="text-primary font-weight-bolder">Đăng ký</a>
									</div>
								</div>
								<!--begin::Title-->
								<div class="form-group">
									<label class="font-size-h6 font-weight-bolder text-dark">Email <label
											style="color: red;">*</label></label>
									<input type="email" id="email" class="form-control form-control-solid h-auto py-7 px-6 border-0 rounded-lg font-size-h6" placeholder="Email" value="" />
									<div class="error" id="email-error"></div>
								</div>
								<!--end::Form group-->
								<!--begin::Form group-->
								<div class="form-group">
									<div class="mt-n5" style="display: flex;justify-content: space-between;">
										<label class="font-size-h6 font-weight-bolder text-dark pt-5">Mật khẩu <label
												style="color: red;">*</label></label>
										<a href="/forgot-password" class="text-primary font-size-h6 font-weight-bolder text-hover-primary pt-5">Quên mật khẩu ?</a>
									</div>
									<input type="password" id="password" class="form-control form-control-solid h-auto py-7 px-6 border-0 rounded-lg font-size-h6" placeholder="Mật khẩu" value="" />
									<div class="error" id="password-error"></div>
								</div>
								<!--end::Form group-->
								<!--begin::Action-->
								<div class="pb-lg-0 pb-5" style="display: flex;justify-content: space-between;">
									<div style="display: flex; padding-top: 22.75px;">
										<button id="login-btn" type="button"
											style="color: #FFFFFF;
													background-color: #187DE4;
													font-size: 1.175rem;
													font-weight: 600;
													border: none;
													padding: 13px 26px;
													border-radius: 0.42rem;">
											Đăng nhập
										</button>
									</div>
								</div>
								<style>
									.error {
										color: red;
										font-size: 0.9em;
										margin-top: 3px;
									}
								</style>
							</div>
							<div id="resendModalLogin" class="verify_modal" style="display: none;">
								<div class="verify_content">
									<h2>⏰ Tài khoản chưa kích hoạt</h2>
									<p>Vui lòng kích hoạt tài khoản.</p>
									<button id="activateBtn">Kích hoạt</button>
								</div>
							</div>

							<div id="activationModal" class="verify_modal" style="display:none;">
								<div class="modal-content">
									<h2 id="resendText">📩 Xác minh email</h2>
									<p>Chúng tôi đã gửi email xác minh đến <span style="color: #187DE4;" id="userEmail"></span></p>
									<p>Vui lòng kiểm tra email để kích hoạt tài khoản.</p>
									<div class="countdown-box" id="countdownBox">
										⏳ Gửi lại sau: <span id="countdown">5:00</span>
									</div>
									<button id="resendBtn" style="display: none;">Gửi lại</button>
								</div>
							</div>
							<!--end::Action-->
						</form>
						<!--end::Form-->
					</div>
					<!--end::Signin-->
				</div>
				<!--end::Wrapper-->
			</div>
			<!--begin::Content-->
			<!--begin::Aside-->
			<div class="login-aside order-1 order-lg-2 bgi-no-repeat bgi-position-x-right">
				<div class="login-conteiner bgi-no-repeat bgi-position-x-right bgi-position-y-bottom" style="background-image: url(assets/media/svg/illustrations/login-visual-4.svg);">
					<!--begin::Aside title-->
					<h3 class="pt-lg-40 pl-lg-20 pb-lg-0 pl-10 py-20 m-0 d-flex justify-content-lg-start font-weight-boldest display5 display1-lg text-white">We Got
						<br />A Surprise
						<br />For You
					</h3>
					<!--end::Aside title-->
				</div>
			</div>
			<!--end::Aside-->
		</div>
		<!--end::Login-->
	</div>
	<!--end::Main-->
	<script>
		var HOST_URL = "https://preview.keenthemes.com/metronic/theme/html/tools/preview";
	</script>
	<!--begin::Global Config(global config for global JS scripts)-->
	<script>
		var KTAppSettings = {
			"breakpoints": {
				"sm": 576,
				"md": 768,
				"lg": 992,
				"xl": 1200,
				"xxl": 1200
			},
			"colors": {
				"theme": {
					"base": {
						"white": "#ffffff",
						"primary": "#6993FF",
						"secondary": "#E5EAEE",
						"success": "#1BC5BD",
						"info": "#8950FC",
						"warning": "#FFA800",
						"danger": "#F64E60",
						"light": "#F3F6F9",
						"dark": "#212121"
					},
					"light": {
						"white": "#ffffff",
						"primary": "#E1E9FF",
						"secondary": "#ECF0F3",
						"success": "#C9F7F5",
						"info": "#EEE5FF",
						"warning": "#FFF4DE",
						"danger": "#FFE2E5",
						"light": "#F3F6F9",
						"dark": "#D6D6E0"
					},
					"inverse": {
						"white": "#ffffff",
						"primary": "#ffffff",
						"secondary": "#212121",
						"success": "#ffffff",
						"info": "#ffffff",
						"warning": "#ffffff",
						"danger": "#ffffff",
						"light": "#464E5F",
						"dark": "#ffffff"
					}
				},
				"gray": {
					"gray-100": "#F3F6F9",
					"gray-200": "#ECF0F3",
					"gray-300": "#E5EAEE",
					"gray-400": "#D6D6E0",
					"gray-500": "#B5B5C3",
					"gray-600": "#80808F",
					"gray-700": "#464E5F",
					"gray-800": "#1B283F",
					"gray-900": "#212121"
				}
			},
			"font-family": "Poppins"
		};
	</script>
	<!--end::Global Config-->
	<!--begin::Global Theme Bundle(used by all pages)-->
	<script src="assets/plugins/global/plugins.bundle.js"></script>
	<script src="assets/plugins/custom/prismjs/prismjs.bundle.js"></script>
	<script src="assets/js/scripts.bundle.js"></script>
	<!--end::Global Theme Bundle-->
	<!--begin::Page Scripts(used by this page)-->
	<script src="assets/js/pages/custom/login/login-4.js"></script>
	<!--end::Page Scripts-->
	<script src="/js/register.js"></script>
	<script src="/js/login.js"></script>
</body>
<!--end::Body-->

</html>