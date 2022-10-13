//splash アニメーション-----------------------------------------------------------------------------
//Vivus SVGアニメーションの描画
var stroke;
stroke = new Vivus('mask', {//アニメーションをするIDの指定
    start:'manual',//自動再生をせずスタートをマニュアルに
    type: 'scenario-sync',// アニメーションのタイプを設定
    duration: 15,//アニメーションの時間設定。数字が小さくなるほど速い
    forceRender: false,//パスが更新された場合に再レンダリングさせない
    animTimingFunction:Vivus.EASE,//動きの加速減速設定
},
function(){
         $("#mask, #splash_logo").attr("class", "done");//描画が終わったらdoneというクラスを追加
}
);

//---------------------------------------------------------
$(window).on('load',function(){
  stroke.play();//SVGアニメーションの実行

  $("#splash-logo").delay(2500).fadeOut('slow');//ロゴを1.2秒でフェードアウトする記述

  //=====ここからローディングエリア（splashエリア）を1.5秒でフェードアウトした後に動かしたいJSをまとめる
  $("#splash").delay(3000).fadeOut('slow',function(){//ローディングエリア（splashエリア）を1.5秒でフェードアウトする記述
  
      $('body').addClass('appear');//フェードアウト後bodyにappearクラス付与

  });
  //=====ここまでローディングエリア（splashエリア）を1.5秒でフェードアウトした後に動かしたいJSをまとめる
  
 //=====ここから背景が伸びた後に動かしたいJSをまとめたい場合は
  $('.splash-bg').on('animationend', function() {    
      //この中に動かしたいJSを記載
  });
  //=====ここまで背景が伸びた後に動かしたいJSをまとめる
      
});

//GSAP topのtop-bgの拡大スクロール----------------------------------------------------------------
/* アニメーション対象要素の初期値を設定 開始 */
gsap.set(".moveItem", { scale: 0 });
//初期状態としてtransform:scale(0);が適用される
 
/* アニメーション対象要素の初期値を設定 終了 */
 
/* アニメーション内容を記述 開始 */
gsap.to("#top-bg", {
  scale: 3, //transform:scale(1)
  ease: "power1.out", // 用意されているイージング詳細は公式:https://greensock.com/docs/v3/Eases

 
  /* アニメーション完了後の状態を記述 終了 */
  scrollTrigger: {
    trigger: "#top",
    //この要素が画面に入ったらgsap.toで記述した要素がアニメーションを開始する(トリガー設定)
    // pin: true,
    //の場合はこの要素がendの数値スクロール分固定される
    start: "top top",
    //トリガー要素のどの部分が画面に入ったらアニメーションを発火するか設定
    end: "bottom top",
    //アニメーション終了位置を設定。この数値のスクロール量でアニメーションが 0% -> 100% に到達
    scrub: true,
    //スクロールとアニメーションを連動させる場合はtrue。数字をセットすることで◯秒遅れでスクロールと連動させる(慣性スクロール)
    // markers: true,
    //デバッグ用マーカーを表示する場合はtrue(triggerの位置、アニメーション開始・終了位置を表示可能)
  },
});

// #top-bgをピン留 -------------------------------------------------------------------
gsap.utils.toArray(".panel").forEach((panel, i) => {
  ScrollTrigger.create({
    trigger: panel,
    start: "top top",
    pin: true, 
    pinSpacing: false,
    scrub: 1, //スクロール量に合わせてアニメーションが進む
    // markers: true,
  });
});


// header fixed ----------------------------------------------------------
// header スクロールすると上部に固定させるための設定を関数でまとめる
function FixedAnime() {
  var headerH = $('#top-bg').outerHeight(true); //#homeの画像を超えたら
  var scroll = $(window).scrollTop();
  if (scroll >= headerH){//headerの高さ以上になったら
      $('#header').addClass('fixed');//fixedというクラス名を付与
    }else{//それ以外は
      $('#header').removeClass('fixed');//fixedというクラス名を除去
    }
}

// 画面をスクロールをしたら動かしたい場合の記述
$(window).scroll(function () {
  FixedAnime();/* スクロール途中からヘッダーを出現させる関数を呼ぶ*/
});

// ページが読み込まれたらすぐに動かしたい場合の記述
$(window).on('load', function () {
  FixedAnime();/* スクロール途中からヘッダーを出現させる関数を呼ぶ*/
});


// グローバルナビゲーション -クリックしたらナビが左から右に出現------------------------
$(".openbtn1").click(function () {//ボタンがクリックされたら
  $(this).toggleClass('active');//ボタン自身に activeクラスを付与し
    $("#g-nav").toggleClass('panelactive');//ナビゲーションにpanelactiveクラスを付与
});

$("#g-nav a").click(function () {//ナビゲーションのリンクがクリックされたら
    $(".openbtn1").removeClass('active');//ボタンの activeクラスを除去し
    $("#g-nav").removeClass('panelactive');//ナビゲーションのpanelactiveクラスも除去
});

// g-nav内　検索窓の設定------------------------------------------
//検索窓を押した時には
$("#search-wrap").click(function () {
    $(this).toggleClass('panelactive');//.open-btnは、クリックごとにbtnactiveクラスを付与＆除去。1回目のクリック時は付与
  $('#search-text').focus();//テキスト入力のinputにフォーカス
  $(".close-btn").toggleClass('btnactive');//.open-btnは、クリックごとにbtnactiveクラスを付与＆除去。1回目のクリック時は付与
});
//閉じるボタン
$(".close-btn").click(function () {
    $(this).toggleClass('btnactive');//.open-btnは、クリックごとにbtnactiveクラスを付与＆除去。1回目のクリック時は付与
    $("#search-wrap").toggleClass('panelactive');//#search-wrapへpanelactiveクラスを付与
  $('#search-text').blur();//テキスト入力のinputにフォーカス解除
});


// 動きのきっかけとなるアニメーションの名前を定義 -----------------------
function fadeAnime(){
  
  // 下から
  $('.fadeUpTrigger').each(function(){ //fadeUpTriggerというクラス名が
    var elemPos = $(this).offset().top-50;//要素より、50px上の
    var scroll = $(window).scrollTop();
    var windowHeight = $(window).height();
    if (scroll >= elemPos - windowHeight){
    $(this).addClass('fadeUp');// 画面内に入ったらfadeUpというクラス名を追記
    }else{
    $(this).removeClass('fadeUp');// 画面外に出たらfadeUpというクラス名を外す
    }
    });
  
  // その場で
  $('.fadeInTrigger').each(function(){ //fadeUpTriggerというクラス名が
    var elemPos = $(this).offset().top-50;//要素より、50px上の
    var scroll = $(window).scrollTop();
    var windowHeight = $(window).height();
    if (scroll >= elemPos - windowHeight){
    $(this).addClass('fadeIn');// 画面内に入ったらfadeUpというクラス名を追記
    }else{
    $(this).removeClass('fadeIn');// 画面外に出たらfadeUpというクラス名を外す
    }
    });
    
  // 右から
  $('.fadeRightTrigger').each(function(){ //fadeUpTriggerというクラス名が
    var elemPos = $(this).offset().top-50;//要素より、50px上の
    var scroll = $(window).scrollTop();
    var windowHeight = $(window).height();
    if (scroll >= elemPos - windowHeight){
    $(this).addClass('fadeRight');// 画面内に入ったらfadeUpというクラス名を追記
    }else{
    $(this).removeClass('fadeRight');// 画面外に出たらfadeUpというクラス名を外す
    }
    });
    
  // 左から
  $('.fadeLeftTrigger').each(function(){ //fadeUpTriggerというクラス名が
    var elemPos = $(this).offset().top-50;//要素より、50px上の
    var scroll = $(window).scrollTop();
    var windowHeight = $(window).height();
    if (scroll >= elemPos - windowHeight){
    $(this).addClass('fadeLeft');// 画面内に入ったらfadeUpというクラス名を追記
    }else{
    $(this).removeClass('fadeLeft');// 画面外に出たらfadeUpというクラス名を外す
    }
    });
    
}
  

// 画面をスクロールをしたら動かしたい場合の記述
  $(window).scroll(function (){
    fadeAnime();/* アニメーション用の関数を呼ぶ*/
  });// ここまで画面をスクロールをしたら動かしたい場合の記述

// 画面が読み込まれたらすぐに動かしたい場合の記述
  $(window).on('load', function(){
    fadeAnime();/* アニメーション用の関数を呼ぶ*/
  });// ここまで画面が読み込まれたらすぐに動かしたい場合の記述
  
//-------------------------------------------------------------------------
// smoothTriggerにsmoothTextAppearというクラス名を付ける定義
function SmoothTextAnime() {
  $('.smoothTextTrigger').each(function(){ //smoothTextTriggerというクラス名が
    var elemPos = $(this).offset().top-50;//要素より、50px上の
    var scroll = $(window).scrollTop();
    var windowHeight = $(window).height();
    if (scroll >= elemPos - windowHeight){
    $(this).addClass('smoothTextAppear');// 画面内に入ったらsmoothTextAppearというクラス名を追記
    }else{
    $(this).removeClass('smoothTextAppear');// 画面外に出たらsmoothTextAppearというクラス名を外す
    }
    }); 
}



// 画面をスクロールをしたら動かしたい場合の記述
$(window).scroll(function () {
  SmoothTextAnime();/* アニメーション用の関数を呼ぶ*/
});// ここまで画面をスクロールをしたら動かしたい場合の記述

// 画面が読み込まれたらすぐに動かしたい場合の記述
$(window).on('load', function () {
  SmoothTextAnime();/* アニメーション用の関数を呼ぶ*/
});// ここまで画面が読み込まれたらすぐに動かしたい場合の記述
  
// ページトップリンク-----------------------------------------------------------------------
//スクロールした際の動きを関数でまとめる
function PageTopAnime() {
  var headerH = $('#event').outerHeight(true);
  var scroll = $(window).scrollTop();
  if (scroll >= headerH){//出現するタイミング
    $('#page-top').removeClass('DownMove');//#page-topについているDownMoveというクラス名を除く
    $('#page-top').addClass('UpMove');//#page-topについているUpMoveというクラス名を付与
  }else{
    if($('#page-top').hasClass('UpMove')){//すでに#page-topにUpMoveというクラス名がついていたら
      $('#page-top').removeClass('UpMove');//UpMoveというクラス名を除き
      $('#page-top').addClass('DownMove');//DownMoveというクラス名を#page-topに付与
    }
  }
}

// 画面をスクロールをしたら動かしたい場合の記述
$(window).scroll(function () {
  PageTopAnime();/* スクロールした際の動きの関数を呼ぶ*/
});

// ページが読み込まれたらすぐに動かしたい場合の記述
$(window).on('load', function () {
  PageTopAnime();/* スクロールした際の動きの関数を呼ぶ*/
});


// #page-topをクリックした際の設定
$('#page-top').click(function () {
  var scroll = $(window).scrollTop(); //スクロール値を取得
  if(scroll > 0){
    $(this).addClass('floatAnime');//クリックしたらfloatAnimeというクラス名が付与
        $('body,html').animate({
            scrollTop: 0
        }, 2000,function(){//スクロールの速さ。数字が大きくなるほど遅くなる
            $('#page-top').removeClass('floatAnime');//上までスクロールしたらfloatAnimeというクラス名を除く
        }); 
  }
    return false;//リンク自体の無効化
});

//slick slider ------------------------------------------------------------------------
$('.slider').slick({
  // fade:true,//切り替えをフェードで行う。初期値はfalse。
  autoplay: true,//自動的に動き出すか。初期値はfalse。
  infinite: true,//スライドをループさせるかどうか。初期値はtrue。
  slidesToShow: 3,//スライドを画面に3枚見せる
  slidesToScroll: 1,//1回のスクロールで3枚の写真を移動して見せる
  prevArrow: '<div class="slick-prev"></div>',//矢印部分PreviewのHTMLを変更
  nextArrow: '<div class="slick-next"></div>',//矢印部分NextのHTMLを変更
  dots: true,//下部ドットナビゲーションの表示
  centerMode: true, //一枚目を中心に表示させる
  centerPadding: '20%',//周囲の画像の表示範囲
  variableWidth: true,//高さを揃える
  initialSlide: 0,//最初に表示させる要素の番号を指定
  // rtl: true,//スライダの表示方向を左⇒右に変更する
  responsive: [
    {
    breakpoint: 1024,//モニターの横幅が769px以下の見せ方
    settings: {
      slidesToShow: 3,//スライドを画面に2枚見せる
      centerMode: true,
      centerPadding: '15%',
    }
  },
  {
    breakpoint: 600,//モニターの横幅が426px以下の見せ方
    settings: {
      slidesToShow: 1,//スライドを画面に1枚見せる
      centerMode: true,
      centerPadding: '0%',
    }
  }
]
});

// event-slider ------------------------------------------------
$('.e-slider').slick({
    autoplay: true,//自動的に動き出すか。初期値はfalse。
    autoplaySpeed: 0,//次のスライドに切り替わる待ち時間
    speed: 8000,//スライドの動きのスピード。初期値は300
    infinite: true,//スライドをループさせるかどうか。初期値はtrue。
    cssEase: 'linear',//スライドの流れを等速に設定
    arrows: false, //左右に出る矢印を非表示
    dots: false,//下部ドットナビゲーションの表示
    swipe: false, // 操作による切り替えはさせない
    pauseOnFocus: false, //フォーカスで一時停止を無効
    pauseOnHover: false, //マウスホバーで一時停止を無効
    pauseOnDotsHover: false,//ドットナビゲーションをマウスホバーで一時停止を無効
    variableWidth: true,//スライドの要素の幅をcssで設定できるようにする
    responsive: [
      {
        breakpoint: 1024,
        settings: {
          //speed: 7000,//スライドの動きのスピード。初期値は300
        }
      },
      {
        breakpoint: 600,
        settings: {
          speed: 6000,//スライドの動きのスピード。初期値は300
        }
      }
    ],
  });

//スマホ用：スライダーをタッチしても止めずにスライドをさせたい場合
$('.home-slider').on('touchmove', function(event, slick, currentSlide, nextSlide){
    $('.home-slider').slick('slickPlay');
});

//----------------------------------------------------------------------------
//GSAP 横スクロール
const listWrapperEl = document.querySelector('.side-scroll-wrap');
const listEl = document.querySelector('.side-scroll-list');

gsap.to(listEl, {
  x: () => -(listEl.clientWidth - listWrapperEl.clientWidth),
  ease: 'none',
  scrollTrigger: {
    trigger: '.side-scroll',//トリガー要素　アニメーションスタート位置
    start: 'top top', // 要素の上端（top）が、ビューポートの上端（top）にきた時
    end: () => `+=${listEl.clientWidth - listWrapperEl.clientWidth}`,
    scrub: true,//スクロール量に合わせてアニメーションが進む
    pin: true,//トリガー要素を固定する
    anticipatePin: 1,//固定のタイミングを早く検知　ガタつき防止効果
    invalidateOnRefresh: true,//リサイズに関係する重要なオプション
    // markers: true,
  },
});