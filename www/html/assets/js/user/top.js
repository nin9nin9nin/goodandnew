//splash アニメーション-----------------------------------------------------------------------------
//Vivus SVGアニメーションの描画
var stroke;
stroke = new Vivus(
  "mask",
  {
    //アニメーションをするIDの指定
    start: "manual", //自動再生をせずスタートをマニュアルに
    type: "scenario-sync", // アニメーションのタイプを設定
    duration: 15, //アニメーションの時間設定。数字が小さくなるほど速い
    forceRender: false, //パスが更新された場合に再レンダリングさせない
    animTimingFunction: Vivus.EASE, //動きの加速減速設定
  },
  function () {
    $("#mask, #splash_logo").attr("class", "done"); //描画が終わったらdoneというクラスを追加
  }
);

//---------------------------------------------------------
$(window).on("load", function () {
  stroke.play(); //SVGアニメーションの実行

  $("#splash-logo").delay(2500).fadeOut("slow"); //ロゴを1.2秒でフェードアウトする記述

  //=====ここからローディングエリア（splashエリア）を1.5秒でフェードアウトした後に動かしたいJSをまとめる
  $("#splash")
    .delay(3000)
    .fadeOut("slow", function () {
      //ローディングエリア（splashエリア）を1.5秒でフェードアウトする記述

      $("body").addClass("appear"); //フェードアウト後bodyにappearクラス付与
    });
  //=====ここまでローディングエリア（splashエリア）を1.5秒でフェードアウトした後に動かしたいJSをまとめる

  //=====ここから背景が伸びた後に動かしたいJSをまとめたい場合は
  $(".splash-bg").on("animationend", function () {
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
  var headerH = $("#top-bg").outerHeight(true); //#homeの画像を超えたら
  var scroll = $(window).scrollTop();
  if (scroll >= headerH) {
    //headerの高さ以上になったら
    $("#header").addClass("fixed"); //fixedというクラス名を付与
  } else {
    //それ以外は
    $("#header").removeClass("fixed"); //fixedというクラス名を除去
  }
}

// 画面をスクロールをしたら動かしたい場合の記述
$(window).scroll(function () {
  FixedAnime(); /* スクロール途中からヘッダーを出現させる関数を呼ぶ*/
});

// ページが読み込まれたらすぐに動かしたい場合の記述
$(window).on("load", function () {
  FixedAnime(); /* スクロール途中からヘッダーを出現させる関数を呼ぶ*/
});

// top-slider ------------------------------------------------
$(".top-slider").slick({
  autoplay: true, //自動的に動き出すか。初期値はfalse。
  autoplaySpeed: 0, //次のスライドに切り替わる待ち時間
  speed: 8000, //スライドの動きのスピード。初期値は300
  infinite: true, //スライドをループさせるかどうか。初期値はtrue。
  cssEase: "linear", //スライドの流れを等速に設定
  arrows: false, //左右に出る矢印を非表示
  dots: false, //下部ドットナビゲーションの表示
  swipe: false, // 操作による切り替えはさせない
  pauseOnFocus: false, //フォーカスで一時停止を無効
  pauseOnHover: false, //マウスホバーで一時停止を無効
  pauseOnDotsHover: false, //ドットナビゲーションをマウスホバーで一時停止を無効
  variableWidth: true, //スライドの要素の幅をcssで設定できるようにする
  responsive: [
    {
      breakpoint: 1024,
      settings: {
        //speed: 7000,//スライドの動きのスピード。初期値は300
      },
    },
    {
      breakpoint: 600,
      settings: {
        speed: 6000, //スライドの動きのスピード。初期値は300
      },
    },
  ],
});

//スマホ用：スライダーをタッチしても止めずにスライドをさせたい場合
$(".top-slider").on(
  "touchmove",
  function (event, slick, currentSlide, nextSlide) {
    $(".top-slider").slick("slickPlay");
  }
);

//GSAP 横スクロール ----------------------------------------------------------------------------------
const listWrapperEl = document.querySelector(".side-scroll-wrap");
const listEl = document.querySelector(".side-scroll-list");

gsap.to(listEl, {
  x: () => -(listEl.clientWidth - listWrapperEl.clientWidth),
  ease: "none",
  scrollTrigger: {
    trigger: ".side-scroll", //トリガー要素　アニメーションスタート位置
    start: "top top", // 要素の上端（top）が、ビューポートの上端（top）にきた時
    end: () => `+=${listEl.clientWidth - listWrapperEl.clientWidth}`,
    scrub: true, //スクロール量に合わせてアニメーションが進む
    pin: true, //トリガー要素を固定する
    anticipatePin: 1, //固定のタイミングを早く検知　ガタつき防止効果
    invalidateOnRefresh: true, //リサイズに関係する重要なオプション
    // markers: true,
  },
});
