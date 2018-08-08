<?php defined("APP") or die() ?>
<section style="background-color: #fff">
<div class="header-frontpage"><h1><?php echo e("Help")?></h1></div>
<div class="container">
    <section class="content-frontpage">
        <div class="container--fluid">
        <div class="row">
		    <div class="col-md-6">
                <ul id="questions">
                    <li><a href="#q1">چرا از پرشین نظرسنجی استفاده کنم؟</a></li>
                    <li><a href="#q2">چه‌طوری می‌تونم نظرسنجی ایجاد کنم؟</a></li>
                    <li><a href="#q3">چه‌طوری می‌تونم نظرسنجی را در سایت/وبلاگ قرار بدم؟</a></li>
                    <li><a href="#q4">چه‌طوری نظرسنجی‌ها را مدیریت کنم؟</a></li>
                </ul>
            </div>
            <div class="col-md-6">
                <div class="faq-sign">
                    <h3>آموزش استفاده از سرویس ایجاد نظرسنجی آنلاین <a href="http://persianpoll.ir" title="پرشین نظرسنجی" >پرشین نظرسنجی</a></h3>
                    <hr />
                    <h3>در صورتی که سوالی برای شما مطرح شده است که در لیست سوالات متداول ما جای نگرفته است می‌توانید یک ایمیل به آدرس info@persianpoll.ir بزنید تا کمتر از چند ساعت جواب‌تان را دریافت کنید.</h3>
                </div>
            </div>
    </div> <!-- row closed -->
</div> <!-- container fluid closed -->
<div class="container--fluid">
        <div class="faq-content">
            <div class="q" id="q1">
                <h2>چرا از پرشین نظرسنجی استفاده کنم؟ <a href="#questions">بازگشت به سوالات</a></h2>
                <p>پرشین نظرسنجی اولین و تنها سایت نظرسنجی آنلاین ایرانی می‌باشد که با قرار دادن پنل و امکانات حرفه‌ای در اختیار شما می‌کوشد تا شما بتوانید با سلیقه خود، فرم آژاکس نظرسنجی ایجاد و مدیریت کنید.</p>
                <p>همچنین می‌توانید با قرار دادن کد گوگل آنالیتیکس (Google Analytics ID) آمار بازدید کنندگان نظرسنجی خود را مشاهده کنید.</p>
		   </div>
            <div class="q" id="q2">
                <h2>چه‌طوری می‌تونم نظرسنجی ایجاد کنم؟ <a href="#questions">بازگشت به سوالات</a></h2>
                <p>وارد صفحه <a href="<?php echo $this->config["url"]?>/create">ساختن نظرسنجی</a> شوید. طبق تصویر زیر ابتدا سوال خود را و سپس جواب‌های مد نظرتان را در کادر مربوطه وارد کنید.</p>
			    <img src="<?php echo $this->config["url"] ?>/themes/<?php echo $this->config["theme"] ?>/img/help/create-poll-1.png" alt="ساختن نظرسنجی" title="ساختن نظرسنجی" />
			    <p>می‌توانید حداکثر 10 گزینه برای جواب سوال در نظر بگیرید. برای نادیده گرفتن گزینه های دیگر، فیلدهای اضافی را خالی بگذارید.</p>
				<p><code>توجه:</code> لطفا از کدهای html در بخش سوال و پاسخ استفاده نکنید، در غیر این‌صورت کدها نادیده گرفته می‌شوند.</p>
				<img src="<?php echo $this->config["url"] ?>/themes/<?php echo $this->config["theme"] ?>/img/help/create-poll-2.png" alt="ساختن نظرسنجی" title="ساختن نظرسنجی" />
                <p>در قسمت شخصی (سفارشی) سازی می‌توانید گزینه‌های اشتراک گذاری، نمایش نتایج تعداد رای و ... را فعال یا غیرفعال کنید، رمز عبور بگذارید و مدت زمان منقضی شدن نظرسنجی را تعیین کنید.</p>
				<img src="<?php echo $this->config["url"] ?>/themes/<?php echo $this->config["theme"] ?>/img/help/create-poll-3.png" alt="ساختن نظرسنجی" title="ساختن نظرسنجی" />
				<p>در مرحله انتخاب قالب می‌توانید با سلیقه خود تم‌های پیشفرض را انتخاب کنید و برای پس زمینه، تصویر بگذارید.</p>
				<img src="<?php echo $this->config["url"] ?>/themes/<?php echo $this->config["theme"] ?>/img/help/create-poll-4.png" alt="ساختن نظرسنجی" title="ساختن نظرسنجی" />
				<p>حالا بر روی دکمه ایجاد کنید کلیک کنید تا نظرسنجی شما ساخته شود.</p>
            </div>
            <div class="q" id="q3">
                <h2>چه‌طوری می‌تونم نظرسنجی را در سایت/وبلاگ قرار بدم؟ <a href="#questions">بازگشت به سوالات</a></h2>
                <p>در کادر نظرسنجی ایجاد شده بر روی دکمه  قرار دادن کلیک کنید تا پنجره مربوطه باز شود. لینک نظرسنجی را می‌توانید مشاهده کنید. برای نمایش دادن فرم نظرسنجی کافیست کد iframe را در قسمت دلخواه سایت یا وبلاگ خود قرار دهید.</p>
                <img src="<?php echo $this->config["url"] ?>/themes/<?php echo $this->config["theme"] ?>/img/help/create-poll-5.png" alt="ساختن نظرسنجی" title="ساختن نظرسنجی" />
				<pre style="text-align: left;">&lt;iframe src=&quot;http://persianpoll.ir/embed/C87ZW&quot; width="350" height="362" scrolling="0" frameborder="0">&lt;/iframe></pre>
				<p>برای تغییر ابعاد می‌توانید مقادیر height و width را در کد تغییر دهید.</p>
            </div>
            <div class="q" id="q4">
                <h2>چه‌طوری نظرسنجی‌ها را مدیریت کنم؟ <a href="#questions">بازگشت به سوالات</a></h2>
                <p>وارد حساب کاربری خود شوید. نظرسنجی ایجاد شده مورد نظر خودتان را پیدا کنید.</p>
                <img src="<?php echo $this->config["url"] ?>/themes/<?php echo $this->config["theme"] ?>/img/help/polls.png" alt="ساختن نظرسنجی" title="ویرایش نظرسنجی" />
				<p>می‌توانید نظرسنجی را حذف کنید یا دسترسی به آن را با بسته کردن، غیرفعال کنید. می‌توانید نظرسنجی را ویرایش کنید، فیلدها را اضافه و یا نام گزینه‌ها را تغیر دهید. همچنین می‌توانید تنظیمات نظرسنجی را تغییر دهید و تم قالب را عوض کنید.</p>               
			    <img src="<?php echo $this->config["url"] ?>/themes/<?php echo $this->config["theme"] ?>/img/help/edit-poll.png" alt="ساختن نظرسنجی" title="ویرایش نظرسنجی" />
			<br /><br /><br />
            </div>
        </div></div>
    </section>
</div>
</section>