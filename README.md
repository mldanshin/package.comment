# Feedback form 
Supports fields:
- name (required, no more than 50 characters);
- email address (optional);
- message (required, no more than 1000 characters).

The so-called old Laravel input is not supported.  
The message is sent using the fetch javascript method.  
The intermediary on the route is limited to sending more than 30 messages per minute.  
Messages are stored in a text file (.txt).  
Supports commands for controlling the file size, and sending released messages to an email address.  
The localizations en, ru are supported.  

## Requirements
- PHP 8.3 or higher
- Laravel 11.0  or higher
- Composer

## Installation
Add to the file composer.json  

    "require": {
        "mldanshin/package-comment": "^1.0"
    }

    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/mldanshin/package-comment"
        }
    ]

Execute

    composer update

## Using
### Step 1 **Required!**
Publish the configuration file

    php artisan vendor:publish

where from the list select Provider: Danshin\Comment\Providers\PackegeServiceProvider. After that, the danshin-comment file will appear in the config folder, where

- limit_comment - the maximum number of messages to store, the rest will be deleted when the command is run (see below);
- mail.subject - subject of the letter;
- *mail.replay_to.address - the e-mail address to which the letters will be sent, the field is mandatory!*

In addition, you must have filled in the fields of the sender of emails in the .env file:
- MAIL_MAILER=
- MAIL_HOST=
- MAIL_PORT=
- MAIL_USERNAME=
- MAIL_PASSWORD=
- MAIL_FROM_ADDRESS=
- MAIL_FROM_NAME=

### Step 2 **Required!**
Include the form view in your views file:

    @include('danshin/comment::form')

### Step 3 **Required!**
Import the javascript Form class into your script file and create a Form object:

    import Form from "../../vendor/mldanshin/package-comment/resources/js/form.js";
    new Form();

The class defines two pop-up events that occur before ("beforeSubmit Comment") and after ("after Submit Comment") the submission of the form. Using them, you can, for example, connect the spinner element to show the start and end of the form submission. After sending the form from the message property, you can get an object containing the results of sending the form. For example
form.message.header returns the message header, form.message.content - message body, form.message.status - result: true(successful) or false(error). This can be used to display a message to the user. Before getting the results, check form.message for null.  

Below is an example of enabling and adding event handlers from my project.  
To the main JS file (for example app.js) adding

    require('./comment.js');

Creating a comment file.js containing the following code

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

### Step 4 **Optional**
Import ready-made Sass styles into your css file:

    @import '../../vendor/mldanshin/package-comment/resources/css/form'

### Step 5 **Required!**
Execute

    npm run dev
or

    npm run production

### Console commands are available:

    php artisan comment:cut
    
Deletes comments beyond the limit set in the configuration file (danshin-comment.limit_comment). Information about deleted records is sent to the mail installed in the configuration file (danshin-comment.mail.replay_to.address), if the value is missing, the information is not sent. Add a command to the scheduler to automate file filling control.

    php artisan comment:clear
    
Completely clears the comments file.

## License

Open source software licensed in accordance with [MIT license](https://opensource.org/licenses/MIT).