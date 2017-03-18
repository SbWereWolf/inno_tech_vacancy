{{ content() }}

<div class="jumbotron">
    <h1>Welcome to Inno Tech Account Viewer</h1>
    <p>
        Приложение разработано по заказу Inno Tech в качестве тестового задания по вакансии "Программист".
        Для использования приложения пожалуйста пройджите процедуру регистрации.
    </p>
    <p>{{ link_to('register', 'Try it for Free &raquo;', 'class': 'btn btn-primary btn-large btn-success') }}</p>
</div>

<div class="row">
    <div class="col-md-4">
        <h2>Постановка задачи</h2>
        <p>Необходимо разработать веб-приложение, позволяющее:
            <ul>
            <li>
                войти в систему
            </li>
            <li>
                просмотреть список зарегистрированных пользователей (доступен
                только после аутентификации)
            </li>
            <li>
                выйти из системы
            </li>
        </ul>
            </p>
        <p>
            Следует использовать PHP7 и Phalcon, базу данных MongoDB.
            Результат выложить на гитхаб.
        </p>
    </div>
    <div class="col-md-6">
        <h2>Пример использования</h2>
        <p>
        <ol>
            <li>Открыть страницу приложения http://&lt;имя сервера&gt;/inno_tech_vacancy/index/index ;</li>
            <li>Нажать кнопку 'Try it for Free &raquo;';</li>
            <li>Заполнить поля;</li>
            <li>Нажать кнопку 'Register';</li>
            <li>Приложение откроет форму аутентификации;</li>
            <li>заполнить поля формы соответствующими значениями;</li>
            <li>Нажать кнопку 'Login';</li>
            <li>Приложение откроет страницу просмотра учётных записей;</li>
            <li>Используя кнопки 'First' 'Previous' 'Next' 'Last' можно просматривать отдельные страницы списка;</li>
            <li>Цель просмотра списка пользователей достигнута.</li>
        </ol>
        </p>
    </div>
    <div class="col-md-2">
        <h2>Сообщите свой мнение !</h2>
        <p>Я буду рад услышать ваш отзыв, напишите мне на <a href="mailto:ulfnew@mail.ru">ulfnew@mail.ru</a></p>
    </div>
</div>
