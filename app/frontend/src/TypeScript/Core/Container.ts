/**
 * @todo finish dependency-injection for container
 * or maybe use microsoft/tsyringe
 */
export class Container {
    private instances = [] as { [key: string]: any };

    public register(instance: any, ...args: any[]): typeof instance {
        if (typeof this.instances[instance.constructor.name] === 'undefined') {
            return;
        }

        this.instances[instance.constructor.name] = new instance(...args);

        return this.instances[instance.constructor.name];
    }

    public resolve(instance: any): typeof instance | null {
        return this.instances[instance.constructor.name];
    }
}
