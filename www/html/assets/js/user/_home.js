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


//bannerスライダー ------------------------------------------------------------------------
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


//Vivus SVGアニメーションの描画 --------------------------------------------------------------------
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


//GSAP 横スクロール ----------------------------------------------------------------------------------
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