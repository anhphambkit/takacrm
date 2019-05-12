export default {
    trans(key, replace = {})
    {
        let arr = new Array();
        arr.push(key);
        let translation = arr.reduce((t, i) => t[i] || null, window.translations);
        translation = translation != null ? translation:key;
        for (var placeholder in replace) {
            translation = translation.replace(`:${placeholder}`, replace[placeholder]);
        }

        return translation;
    },

    renderImageWithNameTable(img, name, link = "#") {
        return `<div class="media">
                        <div class="media-left pr-1"><span class="avatar avatar-sm avatar-online rounded-circle"><img src="${img}"
                                 alt="avatar" class="avatar-table"></span></div>
                        <div class="media-body media-middle">
                            <a class="media-heading name" href="${link}">${name}</a>
                        </div>
                    </div>`
    }
}