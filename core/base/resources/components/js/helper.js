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
                    </div>`;
    },

    renderColorNameTable(colorCode, name) {
        return `<span class="minicolor-preview">
                        <span class="minicolor-square-box" style="background-color: ${colorCode};"></span>
                        </span>
                   <span class="customer-color-attr">${name}</span>`;
    },

    renderStatusBasic(status) {
        let statusClass = 'badge-success';
        let statusName = 'Active';
        if (!status) {
            statusClass = 'badge-secondary';
            statusName = 'De-active';
        }
        return `<div class="badge ${statusClass}">${statusName}</div>`;
    },

    renderActionsTableBasic(linkView, linkEdit, linkDelete) {
        return `<div class="table-actions row">
                        <a href="${linkView}" class="btn btn-table-actions btn-icon btn-pure info mr-1 tip" data-toggle="tooltip" data-placement="top" title="View detail"">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="${linkEdit}" class="btn btn-table-actions btn-icon btn-pure success mr-1 tip" data-toggle="tooltip" data-placement="top" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button type="button" class="btn btn-table-actions btn-icon btn-pure danger mr-1 deleteDialog tip" data-toggle="modal" data-section="${linkDelete}" role="button">
                            <i class="far fa-trash-alt"></i>
                        </button>
                    </div>`;
    },
}