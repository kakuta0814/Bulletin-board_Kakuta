$(function () {
  let like = $('.like-toggle'); //like-toggleのついたiタグを取得し代入。
  let likeReviewId; //変数を宣言（なんでここで？）
  like.on('click', function () { //onはイベントハンドラー
    let $this = $(this); //this=イベントの発火した要素＝iタグを代入
    likeReviewId = $this.data('review-id'); //iタグに仕込んだdata-review-idの値を取得
    //ajax処理スタート
    $.ajax({
      headers: { //HTTPヘッダ情報をヘッダ名と値のマップで記述
        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
      },  //↑name属性がcsrf-tokenのmetaタグのcontent属性の値を取得
      url: '/post_like', //通信先アドレスで、このURLをあとでルートで設定します
      method: 'POST', //HTTPメソッドの種別を指定します。1.9.0以前の場合はtype:を使用。
      data: { //サーバーに送信するデータ
        'review_id': likeReviewId //いいねされた投稿のidを送る
      },
    })
    //通信成功した時の処理
    .done(function (data) {
      $this.toggleClass('liked'); //likedクラスのON/OFF切り替え。
        $this.next('.like-counter').html(data.favorites_count);
        console.log(data);
    })
    //通信失敗した時の処理
    .fail(function () {
      console.log('fail');
    });
  });
  });

// $(function ()
// {
//     //「toggle_wish」というクラスを持つタグがクリックされたときに以下の処理が走る
//     $('.toggle_wish').on('click', function ()
//     {
//     //   alert("hello");
//         //表示しているプロダクトのIDと状態、押下し他ボタンの情報を取得
//         post_id = $(this).attr("post_id");
//         like_product = $(this).attr("like_product");
//         click_button = $(this);



//         $.ajax({
//             headers: {
//                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  //基本的にはデフォルトでOK
//             },
//             url: '/post_like',  //route.phpで指定したコントローラーのメソッドURLを指定
//             type: 'POST',   //GETかPOSTメソットを選択
//             data: { 'post_id': post_id, 'like_product': like_product, }, //コントローラーに送るに名称をつけてデータを指定
//                 })
//             //正常にコントローラーの処理が完了した場合
//             .done(function (data) //コントローラーからのリターンされた値をdataとして指定
//             {
//                 if ( data == 0 )
//                 {
//                     //クリックしたタグのステータスを変更
//                     click_button.attr("like_product", "1");
//                     //クリックしたタグの子の要素を変更(表示されているハートの模様を書き換える)
//                     click_button.children("i").attr("class", "fas fa-heart");
//                 }
//                 if ( data == 1 )
//                 {
//                     //クリックしたタグのステータスを変更
//                     click_button.attr("like_product", "0");
//                     //クリックしたタグの子の要素を変更(表示されているハートの模様を書き換える)
//                     click_button.children("i").attr("class", "far fa-heart");
//                 }
//             })
//             ////正常に処理が完了しなかった場合
//             .fail(function (data)
//             {
//                 alert('いいね処理失敗');
//                 alert(JSON.stringify(data));
//             });
//     });
// });
