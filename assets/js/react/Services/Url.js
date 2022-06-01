import * as R from 'ramda';

export default function UrlHelper() {

    this.url = new URLSearchParams(window.location.search);

    this.add = (key, value) => {
        this.url.append(key, value);
    };

    this.addToggle = (key, value) => {
        this.url.set(key, value);
    };

    this.remove = key => {
        this.url.delete(key);
    };

    this.get = key => {
        return this.url.get(key);
    };

    this.getAll = key => {
        return this.url.getAll(key);
    };

    this.href = () => {
        return `${window.location.origin + window.location.pathname}?${this.url.toString()}`;
    };

    this.origin = () => {
        return window.location.origin;
    };

    this.getUrl = (str, params, api = "/api") => {
        str += params ? `?${this.queryParamEncode(params)}` : "";
        if (R.startsWith("/", str)) {
            str = str.substr(1);
        }
        return `${window.location.origin}${api}/${str}`;
    };

    this.getParams = () => {
        return this.url.toString();
    };

    this.redirect = url => {
        document.location.href = url;
    };

    this.hrefWithoutParams = () => {
        return window.location.origin + window.location.pathname;
    };

    this.queryParamEncode = (obj, prefix) => {
        const str = [];
        Object.keys(obj).forEach((p) => {
            const k = prefix ? `${prefix}[${p}]` : p;
            const v = obj[p];
            str.push((v !== null && typeof v === 'object')
                ? this.queryParamEncode(v, k)
                : `${encodeURIComponent(k)}=${encodeURIComponent(v)}`);
        });
        return str.filter(i => i).join('&');
    };
}

function combineSearchParams(...searchParams) {
    const result = new URLSearchParams();

    searchParams.forEach(params => {
        const entries = params.entries();
        entries.forEach(value => {
            result.append(value[0], value[1]);
        });
    });

    return result;
}

export function buildSearchUrl(path, ...searchParams) {
    const sp = searchParams.map(p => (p instanceof URLSearchParams ? p : new URLSearchParams(p)));

    const params = combineSearchParams(...sp);
    let ret;
    const fullPath = `${window.location.origin}${path}`;
    if (Array.from(params).length > 0) {
        ret = `${fullPath}?${params.toString()}`;
    } else {
        ret = fullPath;
    }
    return ret;
}

export function getFiltersObj(filters) {
    const ret = new URLSearchParams();

    if (!filters) {
        return ret;
    }

    return filters;
}

export function checkProtocol(url) {
    if (typeof url !== "string" || url.length === 0) {
        return "";
    }

    if (url.startsWith("https://") || url.startsWith("http://")) {
        return url;
    }

    return `https://${url}`;
}

export const storageUrl = (href, storage_url) => {
    if (href && !R.startsWith("http", href)) {
        href = `${storage_url}/${href}`;
    }
    return href;
};

export const getWordAfterLastSlash = () => {
    return window.location.href.split('/').pop();// .replace(/[^a-zA-Z0-9]/g, '')
};
