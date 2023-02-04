let downloadForm = document.querySelector(".download");
let downloadChosenBtn = document.querySelector(".downloadchosen");
let downloadAllBtn = document.querySelector(".downloadall");

downloadChosenBtn.addEventListener("click", (e) => {
    e.preventDefault();

    let checkedFiles = downloadForm.querySelectorAll("input:checked");

    let files = new FormData(downloadForm);
    files.append("action", "downloadaction");
    files.append("nonce", archive.nonce);

    for (var i = 0; i < checkedFiles.length; i++) {
        files.append("files[]", checkedFiles[i]);
    }

    fetch(loadgames.url, {
        method: "POST",
        body: files,
    })
        .then((data) => data.blob())
        .then((data) => {
            const aElement = document.createElement('a');
            aElement.setAttribute('download', 'selectedfiles.zip');
            const href = URL.createObjectURL(data);
            aElement.href = href;
            aElement.setAttribute('target', '_blank');
            aElement.click();
            URL.revokeObjectURL(href);
        })
});


downloadAllBtn.addEventListener("click", (e) => {
    e.preventDefault();

    let allFiles = downloadForm.querySelectorAll("input");

    let files = new FormData(downloadForm);
    files.append("action", "downloadaction");
    files.append("nonce", archive.nonce);

    for (var i = 0; i < allFiles.length; i++) {
        files.append("files[]", allFiles[i].value);
        console.log(allFiles[i].value);
    }

    fetch(loadgames.url, {
        method: "POST",
        body: files,
    })
        .then((data) => data.blob())
        .then((data) => {
            const aElement = document.createElement('a');
            aElement.setAttribute('download', 'allfiles.zip');
            const href = URL.createObjectURL(data);
            aElement.href = href;
            aElement.setAttribute('target', '_blank');
            aElement.click();
            URL.revokeObjectURL(href);
        })
});