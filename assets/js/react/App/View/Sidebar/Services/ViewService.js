export const getItemMenuClassName = map => {
    const pathnameSplit = window.location.pathname.split("/");
    const linkSplit = map.link.split("/");
    return linkSplit.every((item, index) => item === pathnameSplit[index]) ? map.options.selectedItem : "";
};
