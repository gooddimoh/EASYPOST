String.prototype.replaceAll = String.prototype.replaceAll || function (obj) {
    let retStr = this;
    for (let x in obj) {
        retStr = retStr.replace(new RegExp(x, 'g'), obj[x]);
    }

    return retStr.toString();
};
