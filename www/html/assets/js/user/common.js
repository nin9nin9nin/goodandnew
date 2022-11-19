// 動きのきっかけとなるアニメーションの名前を定義 -----------------------
function fadeAnime() {
  // 下から
  $(".fadeUpTrigger").each(function () {
    //fadeUpTriggerというクラス名が
    var elemPos = $(this).offset().top - 50; //要素より、50px上の
    var scroll = $(window).scrollTop();
    var windowHeight = $(window).height();
    if (scroll >= elemPos - windowHeight) {
      $(this).addClass("fadeUp"); // 画面内に入ったらfadeUpというクラス名を追記
    } else {
      $(this).removeClass("fadeUp"); // 画面外に出たらfadeUpというクラス名を外す
    }
  });

  // その場で
  $(".fadeInTrigger").each(function () {
    //fadeUpTriggerというクラス名が
    var elemPos = $(this).offset().top - 50; //要素より、50px上の
    var scroll = $(window).scrollTop();
    var windowHeight = $(window).height();
    if (scroll >= elemPos - windowHeight) {
      $(this).addClass("fadeIn"); // 画面内に入ったらfadeUpというクラス名を追記
    } else {
      $(this).removeClass("fadeIn"); // 画面外に出たらfadeUpというクラス名を外す
    }
  });

  // 右から
  $(".fadeRightTrigger").each(function () {
    //fadeUpTriggerというクラス名が
    var elemPos = $(this).offset().top - 50; //要素より、50px上の
    var scroll = $(window).scrollTop();
    var windowHeight = $(window).height();
    if (scroll >= elemPos - windowHeight) {
      $(this).addClass("fadeRight"); // 画面内に入ったらfadeUpというクラス名を追記
    } else {
      $(this).removeClass("fadeRight"); // 画面外に出たらfadeUpというクラス名を外す
    }
  });

  // 左から
  $(".fadeLeftTrigger").each(function () {
    //fadeUpTriggerというクラス名が
    var elemPos = $(this).offset().top - 50; //要素より、50px上の
    var scroll = $(window).scrollTop();
    var windowHeight = $(window).height();
    if (scroll >= elemPos - windowHeight) {
      $(this).addClass("fadeLeft"); // 画面内に入ったらfadeUpというクラス名を追記
    } else {
      $(this).removeClass("fadeLeft"); // 画面外に出たらfadeUpというクラス名を外す
    }
  });
}

// 画面をスクロールをしたら動かしたい場合の記述
$(window).scroll(function () {
  fadeAnime(); /* アニメーション用の関数を呼ぶ*/
}); // ここまで画面をスクロールをしたら動かしたい場合の記述

// 画面が読み込まれたらすぐに動かしたい場合の記述
$(window).on("load", function () {
  fadeAnime(); /* アニメーション用の関数を呼ぶ*/
}); // ここまで画面が読み込まれたらすぐに動かしたい場合の記述

// smoothTriggerにsmoothTextAppearというクラス名を付ける定義 -----------------------------------------
function SmoothTextAnime() {
  $(".smoothTextTrigger").each(function () {
    //smoothTextTriggerというクラス名が
    var elemPos = $(this).offset().top - 50; //要素より、50px上の
    var scroll = $(window).scrollTop();
    var windowHeight = $(window).height();
    if (scroll >= elemPos - windowHeight) {
      $(this).addClass("smoothTextAppear"); // 画面内に入ったらsmoothTextAppearというクラス名を追記
    } else {
      $(this).removeClass("smoothTextAppear"); // 画面外に出たらsmoothTextAppearというクラス名を外す
    }
  });
}

// 画面をスクロールをしたら動かしたい場合の記述
$(window).scroll(function () {
  SmoothTextAnime(); /* アニメーション用の関数を呼ぶ*/
}); // ここまで画面をスクロールをしたら動かしたい場合の記述

// 画面が読み込まれたらすぐに動かしたい場合の記述
$(window).on("load", function () {
  SmoothTextAnime(); /* アニメーション用の関数を呼ぶ*/
}); // ここまで画面が読み込まれたらすぐに動かしたい場合の記述

// グローバルナビゲーション -クリックしたらナビが左から右に出現 ------------------------------
$(".openbtn1").click(function () {
  //ボタンがクリックされたら
  $(this).toggleClass("active"); //ボタン自身に activeクラスを付与し
  $("#g-nav").toggleClass("panelactive"); //ナビゲーションにpanelactiveクラスを付与
});

$("#g-nav a").click(function () {
  //ナビゲーションのリンクがクリックされたら
  $(".openbtn1").removeClass("active"); //ボタンの activeクラスを除去し
  $("#g-nav").removeClass("panelactive"); //ナビゲーションのpanelactiveクラスも除去
});

// g-nav内　検索窓の設定------------------------------------------
//検索窓を押した時には
$("#search-wrap").click(function () {
  $(this).toggleClass("panelactive"); //.open-btnは、クリックごとにbtnactiveクラスを付与＆除去。1回目のクリック時は付与
  $("#search-text").focus(); //テキスト入力のinputにフォーカス
  $(".close-btn").toggleClass("btnactive"); //.open-btnは、クリックごとにbtnactiveクラスを付与＆除去。1回目のクリック時は付与
});
//閉じるボタン
$(".close-btn").click(function () {
  $(this).toggleClass("btnactive"); //.open-btnは、クリックごとにbtnactiveクラスを付与＆除去。1回目のクリック時は付与
  $("#search-wrap").toggleClass("panelactive"); //#search-wrapへpanelactiveクラスを付与
  $("#search-text").blur(); //テキスト入力のinputにフォーカス解除
});

// ページトップリンク-----------------------------------------------------------------------
//スクロールした際の動きを関数でまとめる
function PageTopAnime() {
  var headerH = $("#home").outerHeight(true);
  var scroll = $(window).scrollTop();
  if (scroll >= headerH) {
    //headerの出現に合わせる
    $("#page-top").removeClass("DownMove"); //#page-topについているDownMoveというクラス名を除く
    $("#page-top").addClass("UpMove"); //#page-topについているUpMoveというクラス名を付与
  } else {
    if ($("#page-top").hasClass("UpMove")) {
      //すでに#page-topにUpMoveというクラス名がついていたら
      $("#page-top").removeClass("UpMove"); //UpMoveというクラス名を除き
      $("#page-top").addClass("DownMove"); //DownMoveというクラス名を#page-topに付与
    }
  }
}

// 画面をスクロールをしたら動かしたい場合の記述
$(window).scroll(function () {
  PageTopAnime(); /* スクロールした際の動きの関数を呼ぶ*/
});

// ページが読み込まれたらすぐに動かしたい場合の記述
$(window).on("load", function () {
  PageTopAnime(); /* スクロールした際の動きの関数を呼ぶ*/
});

// #page-topをクリックした際の設定
$("#page-top").click(function () {
  var scroll = $(window).scrollTop(); //スクロール値を取得
  if (scroll > 0) {
    $(this).addClass("floatAnime"); //クリックしたらfloatAnimeというクラス名が付与
    $("body,html").animate(
      {
        scrollTop: 0,
      },
      2000,
      function () {
        //スクロールの速さ。数字が大きくなるほど遅くなる
        $("#page-top").removeClass("floatAnime"); //上までスクロールしたらfloatAnimeというクラス名を除く
      }
    );
  }
  return false; //リンク自体の無効化
});

//frexed-area 画面分割した左側を固定 -------------------------------------------------------
$(window).on("load resize", function () {
  var windowWidth = window.innerWidth;
  var elements = $("#fixed-area");
  if (windowWidth >= 768) {
    Stickyfill.add(elements);
  } else {
    Stickyfill.remove(elements);
  }
});

//アコーディオンをクリックした時の動作 ---------------------------------------------------
$(".title").on("click", function () {
  //タイトル要素をクリックしたら
  var findElm = $(this).next(".list"); //直後のアコーディオンを行うエリアを取得し
  $(findElm).slideToggle(); //アコーディオンの上下動作

  if ($(this).hasClass("close")) {
    //タイトル要素にクラス名closeがあれば
    $(this).removeClass("close"); //クラス名を除去し
  } else {
    //それ以外は
    $(this).addClass("close"); //クラス名closeを付与
  }
});

//slick slider 基礎設定------------------------------------------------------------------------
$(".slider").slick({
  autoplay: true, //自動的に動き出すか。初期値はfalse。
  autoplaySpeed: 3000, //次のスライドに切り替わる待ち時間(6秒設定）
  speed: 2000, //スライドの動きのスピード。初期値は300。(4秒設定)
  infinite: true, //スライドをループさせるかどうか。初期値はtrue。
  centerMode: true,
  centerPadding: "20%",
  initialSlide: 0, //最初に表示させる要素の番号を指定
  slidesToShow: 1,
  slidesToScroll: 1, //1回のスクロールで2枚の写真を移動して見せる
  variableWidth: true, //高さを揃える
  // rtl: true,//スライダの表示方向を左⇒右に変更する
  responsive: [
    {
      breakpoint: 1024,
      settings: {
        arrows: true, //左右の矢印あり
        centerMode: true,
        centerPadding: "15%",
        slidesToShow: 1,
      },
    },
    {
      breakpoint: 600,
      settings: {
        arrows: false, //左右の矢印なし
        centerMode: true,
        centerPadding: "0%",
        slidesToShow: 1,
      },
    },
  ],
  arrows: true, //左右の矢印あり
  prevArrow: '<div class="slick-prev"></div>', //矢印部分PreviewのHTMLを変更
  nextArrow: '<div class="slick-next"></div>', //矢印部分NextのHTMLを変更
  dots: true, //下部ドットナビゲーションの表示
  pauseOnFocus: false, //フォーカスで一時停止を無効
  pauseOnHover: false, //マウスホバーで一時停止を無効
  pauseOnDotsHover: false, //ドットナビゲーションをマウスホバーで一時停止を無効
});

//スマホ用：スライダーをタッチしても止めずにスライドをさせたい場合
$(".slider").on("touchmove", function (event, slick, currentSlide, nextSlide) {
  $(".slider").slick("slickPlay");
});

//フェードスライダー ------------------------------------------------------------------------
$(".fade-slider").slick({
  autoplay: true, //自動的に動き出すか。初期値はfalse。
  autoplaySpeed: 3000, //次のスライドに切り替わる待ち時間(6秒設定）
  speed: 2000, //スライドの動きのスピード。初期値は300。(4秒設定)
  infinite: true, //スライドをループさせるかどうか。初期値はtrue。
  centerMode: true,
  centerPadding: "20%",
  variableWidth: true, //高さを揃える
  slidesToShow: 1,
  slidesToScroll: 1, //1回のスクロールで2枚の写真を移動して見せる
  responsive: [
    {
      breakpoint: 1024,
      settings: {
        arrows: true, //左右の矢印あり
        centerMode: true,
        centerPadding: "15%",
        slidesToShow: 1,
      },
    },
    {
      breakpoint: 600,
      settings: {
        arrows: false, //左右の矢印なし
        centerMode: true,
        centerPadding: "0%",
        slidesToShow: 1,
      },
    },
  ],
  arrows: true, //左右の矢印あり
  prevArrow: '<div class="slick-prev"></div>', //矢印部分PreviewのHTMLを変更
  nextArrow: '<div class="slick-next"></div>', //矢印部分NextのHTMLを変更
  dots: true, //下部ドットナビゲーションの表示
  pauseOnFocus: false, //フォーカスで一時停止を無効
  pauseOnHover: false, //マウスホバーで一時停止を無効
  pauseOnDotsHover: false, //ドットナビゲーションをマウスホバーで一時停止を無効
});

//スマホ用：スライダーをタッチしても止めずにスライドをさせたい場合
$(".fade-slider").on(
  "touchmove",
  function (event, slick, currentSlide, nextSlide) {
    $(".fade-slider").slick("slickPlay");
  }
);

//サブスライダー ------------------------------------------------------------------------
$(".sub-slider").slick({
  fade: true, //切り替えをフェードで行う。初期値はfalse。
  autoplay: true, //自動的に動き出すか。初期値はfalse。
  autoplaySpeed: 3000, //次のスライドに切り替わる待ち時間(3秒設定）
  speed: 2000, //スライドの動きのスピード。初期値は300。(2秒設定)
  infinite: true, //スライドをループさせるかどうか。初期値はtrue。
  // cssEase: 'linear',//スライドの流れを等速に設定
  swipe: false, // 操作による切り替えはさせない
  pauseOnFocus: false, //スライダーをフォーカスした時にスライドを停止させるか
  pauseOnHover: false, //スライダーにマウスホバーした時にスライドを停止させるか
  // centerMode: true,
  // centerPadding: '20%',
  // variableWidth: true,//高さを揃える
  // initialSlide: 0,//最初に表示させる要素の番号を指定
  slidesToShow: 1,
  slidesToScroll: 1, //1回のスクロールで2枚の写真を移動して見せる
  // rtl: true,//スライダの表示方向を左⇒右に変更する
  responsive: [
    {
      breakpoint: 1024,
      settings: {
        arrows: true, //左右の矢印あり
        dots: true, //下部ドットナビゲーションの表示
        // centerMode: true,
        // centerPadding: '15%',
        // slidesToShow: 1
      },
    },
    {
      breakpoint: 600,
      settings: {
        arrows: false, //左右の矢印なし
        dots: false, //下部ドットナビゲーションの表示
        // centerMode: true,
        // centerPadding: '0%',
        // slidesToShow: 1
      },
    },
  ],
  arrows: true, //左右の矢印あり
  prevArrow: '<div class="slick-prev"></div>', //矢印部分PreviewのHTMLを変更
  nextArrow: '<div class="slick-next"></div>', //矢印部分NextのHTMLを変更
  dots: true, //下部ドットナビゲーションの表示
  pauseOnFocus: false, //フォーカスで一時停止を無効
  pauseOnHover: false, //マウスホバーで一時停止を無効
  pauseOnDotsHover: false, //ドットナビゲーションをマウスホバーで一時停止を無効
});

//スマホ用：スライダーをタッチしても止めずにスライドをさせたい場合
$(".sub-slider").on(
  "touchmove",
  function (event, slick, currentSlide, nextSlide) {
    $(".sub-slider").slick("slickPlay");
  }
);

//ショートスライダー -----------------------------------------------------------------------
$(".shrot-slider").slick({
  autoplay: true, //自動的に動き出すか。初期値はfalse。
  autoplaySpeed: 3000, //次のスライドに切り替わる待ち時間
  speed: 2000, //スライドの動きのスピード。初期値は300。
  infinite: true, //スライドをループさせるかどうか。初期値はtrue。
  centerMode: true,
  variableWidth: true, //高さを揃える
  slidesToShow: 1,
  slidesToScroll: 1, //1回のスクロールで3枚の写真を移動して見せる
  responsive: [
    {
      breakpoint: 1024,
      settings: {
        arrows: true, //左右の矢印あり
      },
    },
    {
      breakpoint: 600,
      settings: {
        arrows: false, //左右の矢印なし
      },
    },
  ],
  arrows: true, //左右の矢印あり
  prevArrow: '<div class="slick-prev"></div>', //矢印部分PreviewのHTMLを変更
  nextArrow: '<div class="slick-next"></div>', //矢印部分NextのHTMLを変更
  dots: true, //下部ドットナビゲーションの表示
  pauseOnFocus: false, //フォーカスで一時停止を無効
  pauseOnHover: false, //マウスホバーで一時停止を無効
  pauseOnDotsHover: false, //ドットナビゲーションをマウスホバーで一時停止を無効
});

//スマホ用：スライダーをタッチしても止めずにスライドをさせたい場合
$(".shrot-slider").on(
  "touchmove",
  function (event, slick, currentSlide, nextSlide) {
    $(".shrot-slider").slick("slickPlay");
  }
);

//brand image スライダー -------------------------------------------------------------------
$(".brand-image-slider").slick({
  autoplay: true, //自動的に動き出すか。初期値はfalse。
  autoplaySpeed: 3000, //次のスライドに切り替わる待ち時間
  speed: 1000, //スライドの動きのスピード。初期値は300。
  infinite: true, //スライドをループさせるかどうか。初期値はtrue。
  centerMode: true,
  centerPadding: "0%",
  slidesToShow: 1,
  slidesToScroll: 1, //1回のスクロールで3枚の写真を移動して見せる
  arrows: false, //左右の矢印あり
  dots: true, //下部ドットナビゲーションの表示
  pauseOnFocus: false, //フォーカスで一時停止を無効
  pauseOnHover: false, //マウスホバーで一時停止を無効
  pauseOnDotsHover: false, //ドットナビゲーションをマウスホバーで一時停止を無効
});

//スマホ用：スライダーをタッチしても止めずにスライドをさせたい場合
$(".brand-image-slider").on(
  "touchmove",
  function (event, slick, currentSlide, nextSlide) {
    $(".brand-image-slider").slick("slickPlay");
  }
);

//サムネイル付き　slider -----------------------------------------------------------------
//item-photo 上部画像の設定 ---------------------------------------------------------
// $(".item-photo").slick({
//   infinite: true, //スライドをループさせるかどうか。初期値はtrue。
//   fade: true, //フェードの有効化
//   arrows: true, //左右の矢印あり
//   prevArrow: '<div class="slick-prev"></div>', //矢印部分PreviewのHTMLを変更
//   nextArrow: '<div class="slick-next"></div>', //矢印部分NextのHTMLを変更
// });

// //選択画像の設定
// $(".choice-btn").slick({
//   infinite: true, //スライドをループさせるかどうか。初期値はtrue。
//   slidesToShow: 8, //表示させるスライドの数
//   focusOnSelect: true, //フォーカスの有効化
//   asNavFor: ".item-photo", //連動させるスライドショーのクラス名
// });

// //下の選択画像をスライドさせずに連動して変更させる設定。
// $(".item-photo").on(
//   "beforeChange",
//   function (event, slick, currentSlide, nextSlide) {
//     var index = nextSlide; //次のスライド番号
//     //サムネイルのslick-currentを削除し次のスライド要素にslick-currentを追加
//     $(".choice-btn .slick-slide")
//       .removeClass("slick-current")
//       .eq(index)
//       .addClass("slick-current");
//   }
// );

//750px以下でwrapper付与---------------------------------------
// const CHANGE_WIDTH = 750; // 変更を検知する横幅
// const ADD_CLASS = "wrapper" // 追加するクラス

// $(window).on('load resize', function(){
//   var i_width = $(window).outerWidth(true);
//   if(i_width > CHANGE_WIDTH){
//     if($('.slider-info').hasClass(ADD_CLASS)){
//       $('.slider-info').eq(0).removeClass(ADD_CLASS);
//     }
//   } else {
//     if(!$('.slider-info').hasClass(ADD_CLASS)){
//       $('.slider-info').eq(0).addClass(ADD_CLASS);
//     }
//   }
// });

//gallery 上部画像の設定 ---------------------------------------------------------
$(".gallery").slick({
  infinite: true, //スライドをループさせるかどうか。初期値はtrue。
  fade: true, //フェードの有効化
  arrows: true, //左右の矢印あり
  prevArrow: '<div class="slick-prev"></div>', //矢印部分PreviewのHTMLを変更
  nextArrow: '<div class="slick-next"></div>', //矢印部分NextのHTMLを変更
});

//選択画像の設定
$(".choice-btn").slick({
  infinite: true, //スライドをループさせるかどうか。初期値はtrue。
  slidesToShow: 8, //表示させるスライドの数
  focusOnSelect: true, //フォーカスの有効化
  asNavFor: ".gallery", //連動させるスライドショーのクラス名
});

//下の選択画像をスライドさせずに連動して変更させる設定。
$(".gallery").on(
  "beforeChange",
  function (event, slick, currentSlide, nextSlide) {
    var index = nextSlide; //次のスライド番号
    //サムネイルのslick-currentを削除し次のスライド要素にslick-currentを追加
    $(".choice-btn .slick-slide")
      .removeClass("slick-current")
      .eq(index)
      .addClass("slick-current");
  }
);
