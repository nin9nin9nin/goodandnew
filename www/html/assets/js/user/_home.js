//header スクロールすると上部に固定させるための設定を関数でまとめる-----------------------
function FixedAnime() {
  var headerH = $('#home').outerHeight(true); //#homeの画像を超えたら
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
  var headerH = $('#home').outerHeight(true);
  var scroll = $(window).scrollTop();
  if (scroll >= headerH){//headerの出現に合わせる
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
//banner ------------------------------------------------------------------------
$(function() {
  setTimeout(function() {  
    $('.banner').slick({
    fade:true,//切り替えをフェードで行う。初期値はfalse。
    autoplay: true,//自動的に動き出すか。初期値はfalse。
    autoplaySpeed: 3000,//次のスライドに切り替わる待ち時間
    speed:3000,//スライドの動きのスピード。初期値は300。
    infinite: true,//スライドをループさせるかどうか。初期値はtrue。
    slidesToShow: 1,//スライドを画面に3枚見せる
    slidesToScroll: 1,//1回のスクロールで3枚の写真を移動して見せる
    arrows: false,//左右の矢印なし
    dots: false,//下部ドットナビゲーションの表示
            pauseOnFocus: false,//フォーカスで一時停止を無効
            pauseOnHover: false,//マウスホバーで一時停止を無効
            pauseOnDotsHover: false,//ドットナビゲーションをマウスホバーで一時停止を無効
    });
  }, 5000);
});

//スマホ用：スライダーをタッチしても止めずにスライドをさせたい場合
$('.banner').on('touchmove', function(event, slick, currentSlide, nextSlide){
    $('.banner').slick('slickPlay');
});

//スライドショウ ------------------------------------------------------------------------
$('.home-slider').slick({
    // fade:true,//切り替えをフェードで行う。初期値はfalse。
    autoplay: true,//自動的に動き出すか。初期値はfalse。
    autoplaySpeed: 3000,//次のスライドに切り替わる待ち時間(3秒設定）
    speed: 2000,//スライドの動きのスピード。初期値は300。(2秒設定)
    infinite: true,//スライドをループさせるかどうか。初期値はtrue。
    // cssEase: 'linear',//スライドの流れを等速に設定
    swipe: false, // 操作による切り替えはさせない
    pauseOnFocus: false, //スライダーをフォーカスした時にスライドを停止させるか
    pauseOnHover: false, //スライダーにマウスホバーした時にスライドを停止させるか
    centerMode: true,
    centerPadding: '20%',
    variableWidth: true,//高さを揃える
    initialSlide: 0,//最初に表示させる要素の番号を指定
    slidesToShow: 1,
    slidesToScroll: 1,//1回のスクロールで2枚の写真を移動して見せる
    // rtl: true,//スライダの表示方向を左⇒右に変更する
    responsive: [
      {
        breakpoint: 1024,
        settings: {
          arrows: true, //左右の矢印あり
          dots: true,//下部ドットナビゲーションの表示
          centerMode: true,
          centerPadding: '15%',
          slidesToShow: 1
        }
      },
      {
        breakpoint: 600,
        settings: {
          arrows: false,//左右の矢印なし
          dots: false,//下部ドットナビゲーションの表示
          centerMode: true,
          centerPadding: '0%',
          slidesToShow: 1
        }
      }
    ],
    arrows: true,//左右の矢印あり
    prevArrow: '<div class="slick-prev"></div>',//矢印部分PreviewのHTMLを変更
    nextArrow: '<div class="slick-next"></div>',//矢印部分NextのHTMLを変更
    dots: true,//下部ドットナビゲーションの表示
        pauseOnFocus: false,//フォーカスで一時停止を無効
        pauseOnHover: false,//マウスホバーで一時停止を無効
        pauseOnDotsHover: false,//ドットナビゲーションをマウスホバーで一時停止を無効
    });

//スマホ用：スライダーをタッチしても止めずにスライドをさせたい場合
$('.home-slider').on('touchmove', function(event, slick, currentSlide, nextSlide){
    $('.home-slider').slick('slickPlay');
});

//-----------------------------------------------------------------------------
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

$(window).on('load',function(){
    $("#splash").delay(3500).fadeOut('slow');//ローディング画面を3.5秒待機してからフェイドアウト
  $("#splash_logo").delay(3500).fadeOut('slow');//ロゴを3.5秒待機してからフェイドアウト
        stroke.play();//SVGアニメーションの実行
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