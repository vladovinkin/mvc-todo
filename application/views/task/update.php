<h3>Изменение задачи</h3>
<form action="/task/update/<?= $id ?>" method="post">
	<p>Текст задачи</p>
	<input type="hidden" name="id" value="2">
	<p><textarea rows="3" cols="40" name="description"><?= $text ?></textarea></p>
	<input type="submit" name="Сохранить изменения">
</form>