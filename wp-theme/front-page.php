<?php
/**
 * Homepage — the original Bazikonha design, wired to WooCommerce.
 */
defined( 'ABSPATH' ) || exit;
get_header();
$I = BZK_URI . '/assets/img/';
$wc = class_exists( 'WooCommerce' );
?>
  <main>

    <!-- ============ HERO ============ -->
    <section class="hero" id="top">
      <div class="hero__glow" aria-hidden="true"></div>
      <div class="grid-lines grid-lines--abs" aria-hidden="true"><i></i><i></i><i></i><i></i><i></i></div>
      <div class="container hero__inner">
        <div class="hero__head">
          <h1 class="hero__title">
            <span class="line"><span>وارد بازی شو،</span></span>
            <span class="line"><span>قهرمان <em>تو</em> هستی</span></span>
          </h1>
          <p class="hero__sub">کنسول، دسته، هدست، بازی و گیفت‌کارت؛ همه اورجینال، با گارانتی و ارسال سریع به سراسر ایران.</p>
          <a href="<?php echo bzk_shop_url(); ?>" class="btn btn--lime hero__btn">مشاهده محصولات</a>
        </div>

        <div class="hero__stage">
          <!-- featured product card (right in RTL) -->
          <div class="hero__side hero__side--card">
            <?php $hp = bzk_product( 'BZK-DUALSENSE' ); ?>
            <article class="mini-card">
              <a href="<?php echo $hp ? esc_url( $hp->get_permalink() ) : bzk_shop_url(); ?>"><img src="<?php echo $I; ?>products/product-dualsense.webp" alt="دسته DualSense" width="900" height="1000"></a>
              <div class="mini-card__info">
                <span class="mini-card__label">محصول ویژه</span>
                <strong class="mini-card__price"><?php echo $hp ? bzk_num( $hp->get_price() ) : '۱۹٬۴۸۰٬۰۰۰'; ?> <small>تومان</small></strong>
                <?php echo bzk_cart_button( $hp, 'round-btn', bzk_svg( 'arrow' ), 'افزودن دسته DualSense به سبد' ); ?>
              </div>
            </article>
            <h3 class="mini-card__title"><span class="dot"></span>دسته DualSense</h3>
          </div>

          <div class="hero__char-wrap"><img class="hero__char" src="<?php echo $I; ?>hero/hero-character.webp" alt="کاراکتر بازی‌کن‌ها با دسته بازی" width="1400" height="1750"></div>

          <!-- stats (left in RTL) -->
          <div class="hero__side hero__side--stats">
            <div class="stat"><b><span class="count" data-to="12000">۰</span>+</b><span>گیمر راضی</span></div>
            <div class="stat"><b><span class="count" data-to="24">۰</span> ساعته</b><span>ارسال سفارش در تهران</span></div>
            <div class="stat"><b><span class="count" data-to="18">۰</span> ماه</b><span>گارانتی کنسول‌ها</span></div>
          </div>
        </div>
      </div>
      <div class="hero__ground" aria-hidden="true"><img src="<?php echo $I; ?>hero/hero-ground.png" alt="" width="2560" height="512"></div>
    </section>

    <!-- ============ CATEGORIES ============ -->
    <section class="section categories" id="categories">
      <div class="container">
        <div class="sec-head">
          <span class="eyebrow">دسته‌بندی‌ها</span>
          <h2 class="title reveal-words">هر چیزی که یک گیمر لازم دارد، <span class="muted">یک‌جا و با تضمین اصالت.</span></h2>
        </div>

        <div class="cat-grid">
          <a href="<?php echo bzk_cat_url( 'consoles' ); ?>" class="cat-card" style="--r:-5deg">
            <span class="tag tag--orange">+۴۰ مدل</span>
            <img src="<?php echo $I; ?>categories/cat-consoles.webp" alt="کنسول بازی" loading="lazy" width="600" height="600">
            <div class="cat-card__bar"><div><small>دسته‌بندی</small><strong>کنسول بازی</strong></div><span class="round-btn"><svg viewBox="0 0 24 24"><path d="M19 12H5M11 6l-6 6 6 6" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg></span></div>
          </a>
          <a href="<?php echo bzk_cat_url( 'controllers' ); ?>" class="cat-card" style="--r:3deg">
            <img src="<?php echo $I; ?>categories/cat-controllers.webp" alt="دسته بازی" loading="lazy" width="600" height="600">
            <div class="cat-card__bar"><div><small>دسته‌بندی</small><strong>دسته و کنترلر</strong></div><span class="round-btn"><svg viewBox="0 0 24 24"><path d="M19 12H5M11 6l-6 6 6 6" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg></span></div>
          </a>
          <a href="<?php echo bzk_cat_url( 'headsets' ); ?>" class="cat-card" style="--r:-2deg">
            <span class="tag tag--lime">پرفروش</span>
            <img src="<?php echo $I; ?>categories/cat-headsets.webp" alt="هدست گیمینگ" loading="lazy" width="600" height="600">
            <div class="cat-card__bar"><div><small>دسته‌بندی</small><strong>هدست گیمینگ</strong></div><span class="round-btn"><svg viewBox="0 0 24 24"><path d="M19 12H5M11 6l-6 6 6 6" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg></span></div>
          </a>
          <a href="<?php echo bzk_cat_url( 'games' ); ?>" class="cat-card" style="--r:4deg">
            <img src="<?php echo $I; ?>categories/cat-games.webp" alt="بازی‌ها" loading="lazy" width="600" height="600">
            <div class="cat-card__bar"><div><small>دسته‌بندی</small><strong>بازی‌ها</strong></div><span class="round-btn"><svg viewBox="0 0 24 24"><path d="M19 12H5M11 6l-6 6 6 6" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg></span></div>
          </a>
          <a href="<?php echo bzk_cat_url( 'accessories' ); ?>" class="cat-card" style="--r:-3deg">
            <span class="tag tag--orange">جدید</span>
            <img src="<?php echo $I; ?>categories/cat-accessories.webp" alt="واقعیت مجازی و لوازم جانبی" loading="lazy" width="600" height="600">
            <div class="cat-card__bar"><div><small>دسته‌بندی</small><strong>VR و لوازم جانبی</strong></div><span class="round-btn"><svg viewBox="0 0 24 24"><path d="M19 12H5M11 6l-6 6 6 6" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg></span></div>
          </a>
          <a href="<?php echo bzk_cat_url( 'gift-cards' ); ?>" class="cat-card" style="--r:2deg">
            <img src="<?php echo $I; ?>categories/cat-digital.webp" alt="گیفت‌کارت" loading="lazy" width="600" height="600">
            <div class="cat-card__bar"><div><small>دسته‌بندی</small><strong>گیفت‌کارت</strong></div><span class="round-btn"><svg viewBox="0 0 24 24"><path d="M19 12H5M11 6l-6 6 6 6" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg></span></div>
          </a>
        </div>

        <p class="statement reveal-words">از اولین دسته‌ی بازی تا یک <span class="muted">ست‌آپ کامل حرفه‌ای؛</span> ما کنارت هستیم تا فقط به بُردن فکر کنی.</p>
      </div>
    </section>

    <!-- ============ PERKS (BENTO) ============ -->
    <section class="section perks" id="perks">
      <div class="container">
        <div class="sec-head">
          <span class="eyebrow">چرا بازی‌کن‌ها؟</span>
          <h2 class="title">امتیازهای خرید از ما</h2>
          <p class="lead">خرید تجهیزات گیمینگ باید به اندازه‌ی خود بازی لذت‌بخش باشد.</p>
        </div>

        <div class="bento">
          <article class="bento__card bento__card--tall">
            <div class="bento__text">
              <h3>ضمانت اصالت کالا</h3>
              <p>همه‌ی محصولات اورجینال و پلمب هستند؛ اگر غیر از این بود، کل مبلغ را پس می‌گیری.</p>
            </div>
            <img class="bento__img" src="<?php echo $I; ?>characters/team-01.webp" alt="کاراکتر بازی‌کن‌ها کنار PS5" loading="lazy" width="1000" height="1000">
          </article>

          <article class="bento__card bento__card--tall">
            <div class="bento__text">
              <h3>خرید اقساطی</h3>
              <p>کنسول رویایی‌ات را همین امروز ببر و هزینه‌اش را در چند قسط ماهانه پرداخت کن.</p>
            </div>
            <img class="bento__img bento__img--cut" src="<?php echo $I; ?>characters/signature-character.webp" alt="کاراکتر بازی‌کن‌ها با کیسه خرید" loading="lazy" width="1200" height="1600">
          </article>

          <article class="bento__card">
            <span class="bento__icon"><svg viewBox="0 0 24 24"><path d="M3 7h11v9H3zM14 10h4l3 3v3h-7z" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><circle cx="7" cy="17.5" r="1.8" fill="var(--bg-2)" stroke="currentColor" stroke-width="1.8"/><circle cx="17" cy="17.5" r="1.8" fill="var(--bg-2)" stroke="currentColor" stroke-width="1.8"/></svg></span>
            <div class="bento__text">
              <h3>ارسال سریع و رایگان</h3>
              <p>ارسال ۲۴ ساعته در تهران و رایگان برای خریدهای بالای ۵ میلیون تومان.</p>
            </div>
          </article>

          <article class="bento__card bento__card--cta">
            <div class="bento__text">
              <h3>آماده‌ی شروع بازی؟</h3>
              <p>عضو باشگاه بازی‌کن‌ها شو؛ امتیاز جمع کن، تخفیف بگیر و زودتر از همه از پیشنهادها باخبر شو.</p>
            </div>
            <a href="#join" class="btn btn--lime btn--sm">عضویت رایگان
              <svg viewBox="0 0 24 24" width="16" height="16"><path d="M19 12H5M11 6l-6 6 6 6" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </a>
          </article>
        </div>
      </div>
    </section>

    <!-- ============ DEALS ============ -->
    <section class="section deals" id="deals">
      <div class="container">
       <div class="deals__panel">
        <div class="deals__head">
          <div class="sec-head sec-head--start">
            <span class="eyebrow">پیشنهاد ویژه</span>
            <h2 class="title">تخفیف‌های امروز</h2>
          </div>
          <div class="timer" aria-label="زمان باقی‌مانده">
            <span class="timer__label">پایان تا</span>
            <span class="timer__box" id="tH">۰۰</span><i>:</i>
            <span class="timer__box" id="tM">۰۰</span><i>:</i>
            <span class="timer__box" id="tS">۰۰</span>
          </div>
          <div class="slider-nav">
            <button class="round-btn round-btn--ghost" data-dir="prev" aria-label="قبلی"><svg viewBox="0 0 24 24"><path d="M5 12h14M13 6l6 6-6 6" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
            <button class="round-btn" data-dir="next" aria-label="بعدی"><svg viewBox="0 0 24 24"><path d="M19 12H5M11 6l-6 6 6 6" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
          </div>
        </div>

        <div class="products" id="products">
          <?php
          if ( $wc ) {
            $deals = wc_get_products( array(
              'status'   => 'publish',
              'limit'    => 12,
              'orderby'  => 'menu_order',
              'order'    => 'ASC',
              'category' => array( 'consoles', 'controllers', 'headsets', 'games', 'accessories', 'pc-gaming' ),
            ) );
            foreach ( $deals as $p ) {
              bzk_product_card( $p );
            }
          }
          ?>
        </div>
       </div>
      </div>
    </section>

    <!-- ============ SPOTLIGHT ============ -->
    <section class="section spotlight" id="spotlight">
      <div class="container">
        <div class="sec-head">
          <span class="eyebrow">محصول ویژه‌ی ماه</span>
          <h2 class="title">پلی‌استیشن ۵ اسلیم</h2>
          <p class="lead">نسل جدید بازی با بارگذاری فوق‌سریع، گرافیک خیره‌کننده و دسته‌ای که بازی را در دستانت زنده می‌کند.</p>
        </div>

        <div class="spot">
          <div class="spot__ring" aria-hidden="true"></div>
          <img class="spot__img" src="<?php echo $I; ?>products/product-ps5-slim-photoroom.webp" alt="کنسول پلی‌استیشن ۵ اسلیم" loading="lazy" width="421" height="942">
          <div class="bubble bubble--1"><b class="en"><span class="count" data-to="4" data-latin>0</span>K</b><span>کیفیت تصویر</span></div>
          <div class="bubble bubble--2"><b class="en"><span class="count" data-to="120" data-latin>0</span><small>FPS</small></b><span>نرخ فریم</span></div>
          <div class="bubble bubble--3"><b class="en"><span class="count" data-to="1" data-latin>0</span><small>TB</small></b><span>حافظه SSD</span></div>
          <div class="bubble bubble--4"><b><span class="count" data-to="18">۰</span> <small>ماه</small></b><span>گارانتی</span></div>
        </div>

        <div class="spot__buy">
          <?php $sp = bzk_product( 'BZK-PS5-SLIM' ); ?>
          <?php echo $sp ? bzk_price_html( $sp ) : '<div class="price"><strong>۱۹۱٬۹۸۰٬۰۰۰ <small>تومان</small></strong></div>'; ?>
          <?php echo bzk_cart_button( $sp, 'btn btn--lime', 'افزودن به سبد خرید' ); ?>
          <a href="#installments" class="btn btn--ghost">خرید اقساطی</a>
        </div>
      </div>
    </section>

    <!-- ============ PLATFORMS ============ -->
    <section class="section platforms" id="platforms">
      <div class="container">
        <div class="sec-head">
          <span class="eyebrow">پلتفرم‌ها</span>
          <h2 class="title">دنیای خودت را انتخاب کن</h2>
          <p class="lead">هر پلتفرم، یک دنیای متفاوت. کنسول، بازی و لوازم جانبی هر کدام را یک‌جا ببین.</p>
        </div>
        <div class="plat-grid">
          <a href="<?php echo esc_url( add_query_arg( array( 's' => 'پلی‌استیشن', 'post_type' => 'product' ), home_url( '/' ) ) ); ?>" class="plat" style="--accent:#2f6bff">
            <div class="plat__img"><img src="<?php echo $I; ?>characters/team-01.webp" alt="پلی‌استیشن" loading="lazy" width="1000" height="1000"></div>
            <h3 class="en">PLAYSTATION</h3>
            <span>کنسول، دسته، بازی و PS Plus</span>
          </a>
          <a href="<?php echo esc_url( add_query_arg( array( 's' => 'ایکس‌باکس', 'post_type' => 'product' ), home_url( '/' ) ) ); ?>" class="plat" style="--accent:#36d14a">
            <div class="plat__img"><img src="<?php echo $I; ?>characters/team-02.webp" alt="ایکس‌باکس" loading="lazy" width="1000" height="1000"></div>
            <h3 class="en">XBOX</h3>
            <span>سری X و S، دسته و گیم‌پس</span>
          </a>
          <a href="<?php echo esc_url( add_query_arg( array( 's' => 'نینتندو', 'post_type' => 'product' ), home_url( '/' ) ) ); ?>" class="plat" style="--accent:#ff3d3d">
            <div class="plat__img"><img src="<?php echo $I; ?>characters/team-03.webp" alt="نینتندو" loading="lazy" width="1000" height="1000"></div>
            <h3 class="en">NINTENDO</h3>
            <span>سوییچ، کارتریج و eShop</span>
          </a>
        </div>
      </div>
    </section>

    <!-- ============ HOW TO BUY ============ -->
    <section class="section steps" id="installments">
      <div class="container">
        <div class="sec-head">
          <span class="eyebrow">راهنمای خرید</span>
          <h2 class="title">خرید در ۳ قدم ساده</h2>
          <p class="lead">از انتخاب تا تحویل، کمتر از چند دقیقه وقتت را می‌گیرد.</p>
        </div>
        <div class="steps__grid">
          <article class="step"><span class="step__num en">01</span><h3>انتخاب کن</h3><p>محصول مورد نظرت را پیدا کن و با مقایسه‌ی مشخصات، بهترین را به سبد اضافه کن.</p></article>
          <article class="step"><span class="step__num en">02</span><h3>پرداخت امن</h3><p>به‌صورت نقدی از درگاه بانکی یا به‌صورت اقساطی پرداخت کن.</p></article>
          <article class="step"><span class="step__num en">03</span><h3>تحویل بگیر و بازی کن</h3><p>سفارشت با بسته‌بندی ایمن به دستت می‌رسد؛ فقط کافی است دسته را برداری.</p></article>
        </div>

        <div class="coupon">
          <p class="coupon__text">کد تخفیف اولین خریدت را بردار و ماجراجویی‌ات را شروع کن!</p>
          <div class="coupon__box">
            <code id="couponCode" class="en">BAZIKON10</code>
            <button class="btn btn--lime btn--sm" id="copyBtn">
              <svg viewBox="0 0 24 24" width="16" height="16"><rect x="8" y="8" width="12" height="12" rx="2" fill="none" stroke="currentColor" stroke-width="2"/><path d="M16 8V6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h2" fill="none" stroke="currentColor" stroke-width="2"/></svg>
              <span>کپی کد</span>
            </button>
          </div>
        </div>
      </div>
    </section>

    <!-- ============ SETUP ROADMAP ============ -->
    <section class="section road" id="road">
      <div class="container">
        <div class="sec-head">
          <span class="eyebrow">ست‌آپ‌ساز</span>
          <h2 class="title">ست‌آپت را مرحله‌به‌مرحله بساز</h2>
          <p class="lead">از تازه‌کار تا حرفه‌ای؛ هر مرحله، یک ارتقا برای تجربه‌ی بازی‌ات.</p>
        </div>

        <div class="timeline" id="timeline">
          <div class="timeline__track"><div class="timeline__fill" id="tlFill"></div></div>

          <div class="tl-item">
            <span class="tl-node">۱</span>
            <div class="tl-card"><span class="tl-level">مرحله ۱</span><h3>تازه‌کار</h3>
              <ul><li>یک دسته‌ی باکیفیت</li><li>دو بازی محبوب برای شروع</li><li>اشتراک آنلاین برای بازی با دوستان</li></ul></div>
          </div>
          <div class="tl-item">
            <span class="tl-node">۲</span>
            <div class="tl-card"><span class="tl-level">مرحله ۲</span><h3>صدای واقعی</h3>
              <ul><li>هدست گیمینگ با میکروفون</li><li>صدای سه‌بعدی برای شنیدن قدم‌های حریف</li></ul></div>
          </div>
          <div class="tl-item">
            <span class="tl-node">۳</span>
            <div class="tl-card"><span class="tl-level">مرحله ۳</span><h3>نسل جدید</h3>
              <ul><li>کنسول PS5 یا Xbox Series X</li><li>بازی‌های انحصاری نسل نهم</li></ul></div>
          </div>
          <div class="tl-item">
            <span class="tl-node">۴</span>
            <div class="tl-card"><span class="tl-level">مرحله ۴</span><h3>همیشه آماده</h3>
              <ul><li>پایه‌ی شارژ دوتایی دسته</li><li>کیف حمل کنسول</li><li>باتری یدک دسته</li></ul></div>
          </div>
          <div class="tl-item">
            <span class="tl-node">۵</span>
            <div class="tl-card"><span class="tl-level">مرحله ۵</span><h3>حرفه‌ای</h3>
              <ul><li>هدست واقعیت مجازی</li><li>موس و کیبورد گیمینگ</li><li>دسته‌ی دوم برای بازی دونفره</li></ul></div>
          </div>
        </div>
      </div>
    </section>

    <!-- ============ 3D CONTROLLER (scroll-driven rotation) ============ -->
    <section class="spin" id="spin" aria-label="دسته بی‌سیم ایکس‌باکس">
      <div class="spin__sticky">
        <div class="container spin__inner">
          <div class="spin__text">
            <span class="eyebrow">دسته بی‌سیم ایکس‌باکس</span>
            <h2 class="title">از هر زاویه،<br><span class="hl">آماده‌ی بُرد</span></h2>
            <p class="lead">طراحی ارگونومیک، دکمه‌های دقیق و اتصال بی‌سیم پایدار؛ اسکرول کن و دسته را از هر طرف ببین.</p>
            <ul class="spin__feats">
              <li data-at="0.15"><b>بی‌سیم + بلوتوث</b><span>ایکس‌باکس، PC و موبایل</span></li>
              <li data-at="0.45"><b>تا ۴۰ ساعت</b><span>شارژدهی با باتری</span></li>
              <li data-at="0.75"><b>دکمه‌ی Share</b><span>ضبط و اشتراک لحظه‌ها</span></li>
            </ul>
            <div class="spin__buy">
              <?php $xp = bzk_product( 'BZK-XBOX-CTRL' ); ?>
              <?php echo $xp ? bzk_price_html( $xp ) : '<div class="price"><strong>۱۶٬۹۰۰٬۰۰۰ <small>تومان</small></strong></div>'; ?>
              <?php echo bzk_cart_button( $xp, 'btn btn--lime', 'افزودن به سبد' ); ?>
            </div>
          </div>
          <div class="spin__stage">
            <canvas class="spin__canvas" id="spinCanvas" width="718" height="668" role="img" aria-label="دسته بی‌سیم ایکس‌باکس در حال چرخش"></canvas>
            <div class="spin__progress" aria-hidden="true"><i id="spinBar"></i></div>
          </div>
        </div>
      </div>
    </section>

    <!-- ============ GIFT CARDS ============ -->
    <section class="section gifts" id="giftcards">
      <div class="container">
        <div class="sec-head">
          <span class="eyebrow">خرید گیفت‌کارت و اشتراک</span>
          <h2 class="title">گیفت‌کارت بخر،<br><span class="hl">کدت را در چند ثانیه بگیر</span></h2>
          <p class="lead">گیفت‌کارت پلی‌استیشن، ایکس‌باکس، استیم و نینتندو را با قیمت به‌روز بخر؛ کد بعد از پرداخت در پنل کاربری و ایمیلت ارسال می‌شود.</p>
        </div>

        <ul class="gift-perks">
          <li>تحویل سریع کد</li>
          <li>کدهای قانونی و معتبر</li>
          <li>پشتیبانی تا فعال‌سازی</li>
          <li>پرداخت با همه‌ی کارت‌های بانکی</li>
        </ul>

        <div class="gift-grid">
          <?php
          $gifts = $wc ? wc_get_products( array( 'status' => 'publish', 'limit' => 6, 'orderby' => 'menu_order', 'order' => 'ASC', 'category' => array( 'gift-cards' ) ) ) : array();
          foreach ( $gifts as $g ) :
            $hot = $g->get_meta( '_bzk_hot' );
            $img = $g->get_image_id() ? wp_get_attachment_image_url( $g->get_image_id(), 'woocommerce_thumbnail' ) : wc_placeholder_img_src();
            ?>
          <article class="gift">
            <?php if ( $hot ) : ?><span class="gift__hot"><?php echo esc_html( $hot ); ?></span><?php endif; ?>
            <a class="gift__img" href="<?php echo esc_url( $g->get_permalink() ); ?>"><img src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( $g->get_name() ); ?>" loading="lazy" width="600" height="600"></a>
            <h3 class="gift__name en"><?php echo esc_html( $g->get_name() ); ?></h3>
            <span class="gift__sub"><?php echo esc_html( $g->get_meta( '_bzk_sub' ) ); ?></span>
            <div class="gift__foot">
              <div class="gift__price"><small>قیمت</small><strong><?php echo bzk_num( $g->get_price() ); ?> <small>تومان</small></strong></div>
              <?php echo bzk_cart_button( $g, 'btn btn--lime btn--sm', 'خرید', 'خرید ' . $g->get_name() ); ?>
            </div>
          </article>
          <?php endforeach; ?>
        </div>

        <div class="gift-how">
          <div class="gift-how__steps">
            <div><b class="en">01</b><span>گیفت‌کارت و مبلغ را انتخاب کن</span></div>
            <i></i>
            <div><b class="en">02</b><span>آنلاین پرداخت کن</span></div>
            <i></i>
            <div><b class="en">03</b><span>کد را فوراً دریافت کن</span></div>
          </div>
          <a href="<?php echo bzk_cat_url( 'gift-cards' ); ?>" class="btn btn--lime">مشاهده همه‌ی گیفت‌کارت‌ها <svg viewBox="0 0 24 24" width="16" height="16"><path d="M19 12H5M11 6l-6 6 6 6" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg></a>
        </div>
      </div>
    </section>

    <!-- ============ FAQ ============ -->
    <section class="section faq" id="faq">
      <div class="container container--narrow">
        <div class="sec-head">
          <span class="eyebrow">سوالات متداول</span>
          <h2 class="title">پرسش‌های پرتکرار</h2>
          <p class="lead">پاسخ سوال‌هایی که معمولاً قبل از خرید برای گیمرها پیش می‌آید.</p>
        </div>
        <div class="accordion">
          <details class="acc"><summary>۱. محصولات شما اورجینال هستند؟<span class="acc__icon"></span></summary><div class="acc__body"><p>بله. همه‌ی کالاها اورجینال و پلمب هستند و با ضمانت اصالت عرضه می‌شوند. در صورت مغایرت، کل مبلغ بازگردانده می‌شود.</p></div></details>
          <details class="acc"><summary>۲. ارسال سفارش چقدر طول می‌کشد؟<span class="acc__icon"></span></summary><div class="acc__body"><p>سفارش‌های تهران معمولاً ظرف ۲۴ ساعت و سایر شهرها بین ۲ تا ۴ روز کاری تحویل داده می‌شوند.</p></div></details>
          <details class="acc"><summary>۳. شرایط خرید اقساطی چیست؟<span class="acc__icon"></span></summary><div class="acc__body"><p>می‌توانی کالاهای منتخب را در اقساط ماهانه بخری. جزئیات شرایط و تعداد اقساط در صفحه‌ی هر محصول نمایش داده می‌شود.</p></div></details>
          <details class="acc"><summary>۴. گارانتی کنسول‌ها چگونه است؟<span class="acc__icon"></span></summary><div class="acc__body"><p>کنسول‌ها با گارانتی معتبر عرضه می‌شوند و در دوره‌ی گارانتی، تعمیر یا تعویض بدون هزینه انجام می‌شود.</p></div></details>
          <details class="acc"><summary>۵. گیفت‌کارت را چطور دریافت می‌کنم؟<span class="acc__icon"></span></summary><div class="acc__body"><p>بعد از تأیید پرداخت، کد گیفت‌کارت در بخش سفارش‌های پنل کاربری و ایمیلت ارسال می‌شود.</p></div></details>
        </div>
      </div>
    </section>

    <!-- ============ CTA ============ -->
    <section class="section cta" id="join">
      <div class="container">
        <div class="cta__box">
          <div class="cta__clip"><img class="cta__img" src="<?php echo $I; ?>characters/cta-characters.webp" alt="کاراکتر بازی‌کن‌ها روی انبوهی از تجهیزات گیمینگ" loading="lazy" width="1600" height="1200"></div>
          <div class="cta__text">
            <span class="eyebrow">شروع کن</span>
            <h2>همین حالا<br>وارد بازی شو!</h2>
            <p>به باشگاه گیمرهای بازی‌کن‌ها بپیوند؛ از تخفیف‌ها، مسابقه‌ها و محصولات جدید زودتر از همه باخبر شو.</p>
            <a href="<?php echo esc_url( function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'myaccount' ) : wp_registration_url() ); ?>" class="btn btn--lime">عضویت در باشگاه</a>
          </div>
        </div>
      </div>
    </section>
  </main>
<?php get_footer(); ?>
