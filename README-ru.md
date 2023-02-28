# Форма обратной связи 
Поддерживает поля:
- имя (обязательное, не более 50 символов);
- адрес электронной почты (не обязательное);
- сообщение (обязательное, не более 1000 символов).

Не поддерживается, так называемый, старый ввод Laravel.  
Сообщение отправляется с помощью методом fetch javascript.  
Посредником на маршруте ограничена отправка более 30 сообщений в минуту.  
Сообщения хранятся в текстовом файле (.txt).  
Поддерживает команды для контроля размера файла, и отсылки освобождаемых сообщений на адрес электронной почты.  
Поддерживаются локализации en, ru.  

## Требования
- PHP 8.3 или выше  
- Laravel 11.0  или выше
- Composer

## Установка
Добавьте в файл composer.json  

    "require": {
        "mldanshin/package-comment": "^1.0"
    }

    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/mldanshin/package-comment"
        }
    ]

Выполните

    composer update

## Использование
### Шаг 1 **Требуется!**
Опубликуйте конфигурационный файл

    php artisan vendor:publish

где из списка выберите Provider: Danshin\Comment\Providers\PackegeServiceProvider. После чего в папке конфиг появится файл danshin-comment, где  

- limit_comment - максимальное количество сообщений для хранения, остальные при запуске команды (смотри ниже) будут удалены;
- mail.subject - тема письма;
- *mail.replay_to.address - адрес электронной почты, куда будут направляться письма, поле обязательно для заполнения!*

Кроме этого у Вас должны быть заполнены поля отправителя электронных писем в файле .env:
- MAIL_MAILER=
- MAIL_HOST=
- MAIL_PORT=
- MAIL_USERNAME=
- MAIL_PASSWORD=
- MAIL_FROM_ADDRESS=
- MAIL_FROM_NAME=

### Шаг 2 **Требуется!**
Включите представление формы в Ваш файл-представления:

    @include('danshin/comment::form')

### Шаг 3 **Требуется!**
Импортируйте javascript класс Form в Ваш файл скрипта и создайте объект Form:

    import Form from "../../vendor/mldanshin/package-comment/resources/js/form.js";
    new Form();

В классе определены два всплывающих события, возникающие до ("beforeSubmitComment") и после ("afterSubmitComment") отправления формы. Используя их, Вы можете например подключить элемент spinner, чтобы показать начало и окончание отправления формы. После отправления формы из свойства message можно получить объект содержащий результаты отправления формы. Например 
form.message.header возвращает заголовок сообщения, form.message.content - тело сообщения, form.message.status - результат: true(успешно) или false(ошибка). Это можно использовать для отображения сообщения пользователю. Перед получением результатов, проверьте form.message на null.  

Ниже пример включения и добавление обработчиков событий из моего проекта.  
В основной файл JS (например app.js) добавляем

    require('./comment.js');

Создаём файл comment.js, содержащий следующий код

    import Form from "../../vendor/mldanshin/package-comment/resources/js/Form.js";
    import spinner from './spinner';
    import toast from './toast.js';

    let form = new Form();

    document.addEventListener("beforeSubmitComment", () => {
        spinner.on();
    });

    document.addEventListener("afterSubmitComment", () => {
        spinner.off();
        if (form.message !== null) {
            toast.header.innerText = form.message.header;
            toast.message.innerText = form.message.content;
            toast.show();
        }
    });

### Шаг 4 **По желанию**
Импортируйте уже готовые стили Sass в Ваш scss файл:

    @import '../../vendor/mldanshin/package-comment/resources/css/form'

### Шаг 5 **Требуется!**
Выполните

    npm run dev
или

    npm run production

### Доступны консольные команды:

    php artisan comment:cut
    
Удаляет комментарии сверх установленного в конфигурационном файле (danshin-comment.limit_comment) лимита. Сведения об удалённых записях отсылаются на установленную в конфигурационном файле почту (danshin-comment.mail.replay_to.address), если значение отсутствует, сведения не отправляются. Добавьте команду в планировщик  для автоматизации контроля за наполнением файла.

    php artisan comment:clear
    
Полностью очищает файл комментариев.

## Лицензия

Программное обеспечение с открытым исходным кодом, лицензированное в соответствии с [MIT license](https://opensource.org/licenses/MIT).
 