import 'virtual:windi.css';
import '../Scss/app.scss';
import { Container } from './Core/Container';

// @ts-ignore
if (import.meta.hot) {
    // @ts-ignore
    import.meta.hot.accept();
}

interface BaseApplication {
    getContainer: Function;
}

class Application implements BaseApplication {
    private container: Container;

    public constructor() {
        this.container = new Container();
    }

    getContainer(): Container {
        return this.container;
    }
}

new Application();

console.log('test');
