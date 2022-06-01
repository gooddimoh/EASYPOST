export class CookieHandlers {

    get = (name) => {
        const matches = document.cookie.match(
            new RegExp(`(?:^|; )${name.replace(/([.$?*|{}()[\]\\/+^])/g, '\\$1')}=([^;]*)`),
        );
        return matches ? decodeURIComponent(matches[1]) : undefined;
    };

    remove = (name) => {
        document.cookie = `${name}=; path=/; expires='Thu, 01 Jan 1970 00:00:01 GMT'`;
    };

    set = (name, value, expires = '', path = '/') => {
        let cookie = `${name}=${value}; path=${path};`;

        if (expires) {
            cookie += `expires=${expires};`;
        }

        document.cookie = cookie;
        return cookie;
    };
}
