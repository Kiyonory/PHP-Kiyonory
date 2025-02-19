<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Бюдаев Юрий 241-321 2laba</title>
</head>
<body>
    <header style="display: flex; justify-content: left; gap: 5%;">
        <img src="./Logo_Polytech_rus_main.jpg" alt="Логотип" style="width: 30%; height: 20%;">
        <h1>Домашняя работа: Feedback form</h1>
    </header>
    <main>
        <section>
            <form action="https;//httpbin.org/post" method="post" style="display: flex; flex-direction: column;">
                <h2>Форма</h2>
                <label for="name">
                    Имя пользователя:
                    <input type="text" id="name" name="name">
                </label>
                <label for="email">
                    Email:
                    <input type="email" id="email" name="email">
                </label>
                <fieldset>
                    <legend>
                        Тип обращения
                    </legend>
                    <label for="type_of_message">
                        Жалоба
                        <input type="radio" id="type_of_message" value="complaint">
                    </label>
                    <label for="type_of_message1">
                        Предложение
                        <input type="radio" id="type_of_message1" value="suggestion">
                    </label>
                    <label for="type_of_message2">
                        Благодарность
                        <input type="radio" id="type_of_message2" value="gratitude">
                    </label>
                </fieldset>
                <label for="message">
                    Обращение
                    <input type="text" id="message" name="message">
                </label>
                <fieldset>
                    <legend>
                        Как вам ответить
                    </legend>
                    <label for="sms">
                        SMS
                        <input type="checkbox" name="response" value="sms">
                    </label>
                    <label for="Email">
                        Email
                        <input type="checkbox" name="response" value="Email">
                    </label>

                </fieldset>
                <div>
                    <button type="submit">
                        Отправить
                    </button>
                    <a href="index1.php">2 страница</a>
                </div>
            </form>
        </section>
    </main>
    <footer>
        <p>Бюдаев Юрий 241-321 2laba</p>
    </footer>
</body>
</html>