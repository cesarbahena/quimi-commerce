import '../css/main.scss';
import { Application } from '@hotwired/stimulus';
import { start as startTurbo } from '@hotwired/turbo';

const app = Application.start();

app.register('hello', class extends window.Stimulus.Controller {
    static targets = ['output'];

    greet() {
        this.outputTarget.textContent = 'Hello, World!';
    }
});

startTurbo();
