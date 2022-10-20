// タグ編集用フォーム
const editTagForm = document.forms.editTagForm;
// タグの削除用フォーム
const deleteTagForm = document.forms.deleteTagForm;
// 削除の確認メッセージ
const deleteMessage = document.getElementById("deleteTagModalLabel");

// タグの編集用モーダルを開くときの処理
/*==================================================================================================================
1. モーダルを開くときにクリックされた編集ボタンを取得する
2. その編集ボタンに設定されているdata-tag-id属性とdata-tag-name属性の値を取得する
3. 編集用モーダル内にあるformタグのaction属性に、送信先のURL（tags/取得したdata-tag-id属性の値）を代入する
4. 編集用モーダル内にあるinputタグのvalue属性に、取得したdata-tag-name属性の値を代入する
==================================================================================================================*/
document.getElementById("editTagModal").addEventListener("show.bs.modal", (event) => {
    let tagButton = event.relatedTarget;
    let tagId = tagButton.dataset.tagId;
    let tagName = tagButton.dataset.tagName;

    editTagForm.action = `tags/${tagId}`;
    editTagForm.name.value = tagName;
});

// タグの削除用モーダルを開くときの処理
/*==========================================================================================================================================
1. モーダルを開くときにクリックされた削除ボタンを取得する
2. その削除ボタンに設定されているdata-tag-id属性とdata-tag-name属性の値を取得する
3. 削除用モーダル内にあるformタグのaction属性に送信先のURL（tags/取得したdata-tag-id属性の値）を代入する
4. 削除用モーダル内にあるh5要素のテキストに、「『取得したdata-tag-name属性の値』を削除してもよろしいですか？」というメッセージを代入する
==========================================================================================================================================*/
document.getElementById("deleteTagModal").addEventListener("show.bs.modal", (event) => {
    let deleteButton = event.relatedTarget;
    let tagId = deleteButton.dataset.tagId;
    let tagName = deleteButton.dataset.tagName;

    deleteTagForm.action = `tags/${tagId}`;
    deleteMessage.textContent = `「${tagName}」を削除してもよろしいですか？`;
});
