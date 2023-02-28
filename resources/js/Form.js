"use strict";

export default class Form
{
    constructor()
    {
        this._commentForm = document.getElementById("comment-form");
        if (this._commentForm) {
            this._commentForm.addEventListener("submit", this);
        }

        this._beforeSubmit = new CustomEvent("beforeSubmitComment", {bubbles: true});
        this._afterSubmit = new CustomEvent("afterSubmitComment", {bubbles: true});

        this._messageErrorHeader = document.getElementById("comment-message-error-header").innerText;
        this._messageErrorContent = document.getElementById("comment-message-error-content").innerText;

        this._logForm = document.getElementById("comment-log-form");

        /**
         * @type {?object}
         */
        this._message = null;
    }

    handleEvent(event) {
        switch (event.type) {
            case "submit":
                this.sendForm(event);
                break;
        }
    }

    async sendForm(event)
    {
        event.preventDefault();
        this._commentForm.dispatchEvent(this._beforeSubmit);

        try {
            let formData = new FormData(this._commentForm);
            let response = await fetch(this._commentForm.action, {method: 'POST', body: formData} );
        
            if (response.ok) {
                let json = await response.json();
                this._commentForm.reset();
                this._message = {
                    header: json.header,
                    content: json.content,
                    status: true
                };
            } else {
                this._message = {
                    header: this._messageErrorHeader,
                    content: this._messageErrorContent,
                    status: false
                };
                this.sendLog("A response was received from the server " + response.status + ". ");
            }
        } catch (error) {
            this._message = {
                header: this._messageErrorHeader,
                content: this._messageErrorContent,
                status: false
            };
            this.sendLog(error);
        } finally {
            this._commentForm.dispatchEvent(this._afterSubmit);
        }
    }

    /**
     * 
     * @param {string} message 
     */
    async sendLog(message)
    {
        try {
            let formData = new FormData(this._logForm);
            formData.append("message", message);
            await fetch(this._logForm.action, {method: 'POST', body: formData} );
        } catch {

        }
    }

    get message()
    {
        return this._message;
    }
}
