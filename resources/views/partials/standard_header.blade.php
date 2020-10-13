<header class="primary-header">
	<div class="primary-header-section">
		<div class="primary-header-section-container">
			<span class="main-menu-toggle">
				<svg version="1.1" class="hamburger-menu" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="10" height="40">
					<rect rx="2" fill="#93cef7" y="0" width="8" height="8"></rect>
					<rect rx="2" fill="#93cef7" y="16" width="8" height="8"></rect>
					<rect rx="2" fill="#93cef7" y="32" width="8" height="8"></rect>
				</svg>
				<span class="main-menu-toggle-text">Menu</span>
			</span>
			<a class="header-logo" href="{{ route('home') }}">
				<img width="250" height="72" src="/assets/images/logos/cheeky-scientist-logo-white.png"
				 	srcset="/assets/images/logos/cheeky-scientist-logo-white.svg" alt="Cheeky Scientist Logo">
			</a>

			<span class="flex-spacer"></span>

			<ul class="secondary-nav-menu">
				<li><a rel="noopener" target="_blank" href="https://cheekyscientist.com/contact/">Contact Us</a></li>
				<li><a href="{{ route('account.logout') }}">Logout</a></li>
			</ul>
		</div>
		<div class="header-search-form">
			<div class="header-search">
				<span class="header-search-toggle">
					<i class="fas fa-search"></i>
				</span>
			</div>
		</div>
	</div>
</header>
