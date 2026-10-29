import Quill from 'quill';
import 'quill/dist/quill.snow.css';

const form = document.getElementById('blog-post-form');

if (form) {
    initTags();
    initEditor();
}

// ── Etiquetas ──────────────────────────────────────────────────────────
function initTags() {
    const chipsContainer = document.getElementById('tags-chips');
    const hiddenContainer = document.getElementById('tags-hidden');
    const tagField = document.getElementById('tags-field');
    let tags = JSON.parse(form.dataset.initialTags || '[]');

    function renderTags() {
        chipsContainer.innerHTML = '';
        hiddenContainer.innerHTML = '';

        tags.forEach((tag, i) => {
            const chip = document.createElement('span');
            chip.className = 'tags-input__chip';
            chip.textContent = `${tag} `;

            const remove = document.createElement('button');
            remove.type = 'button';
            remove.className = 'tags-input__remove';
            remove.dataset.index = i;
            remove.innerHTML = '&times;';
            chip.appendChild(remove);

            chipsContainer.appendChild(chip);

            const hidden = document.createElement('input');
            hidden.type = 'hidden';
            hidden.name = 'tags[]';
            hidden.value = tag;
            hiddenContainer.appendChild(hidden);
        });
    }

    chipsContainer.addEventListener('click', (e) => {
        if (e.target.classList.contains('tags-input__remove')) {
            tags.splice(Number(e.target.dataset.index), 1);
            renderTags();
        }
    });

    tagField.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' || e.key === ',') {
            e.preventDefault();
            const val = tagField.value.trim().replace(/,$/, '');
            if (val && !tags.includes(val)) {
                tags.push(val);
                renderTags();
            }
            tagField.value = '';
        }
    });

    renderTags();
}

// ── Editor de contenido (Quill) ────────────────────────────────────────
function initEditor() {
    const contentHidden = document.getElementById('content');
    const uploadUrl = form.dataset.uploadUrl;

    const quill = new Quill('#content-editor', {
        theme: 'snow',
        placeholder: 'Escribe el contenido del artículo...',
        modules: {
            toolbar: {
                container: [
                    [{ header: [2, 3, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ list: 'ordered' }, { list: 'bullet' }],
                    ['blockquote', 'code-block'],
                    ['link', 'image', 'video'],
                    ['clean'],
                ],
                handlers: {
                    image: () => uploadImage(quill, uploadUrl),
                },
            },
        },
    });

    if (contentHidden.value) {
        quill.root.innerHTML = contentHidden.value;
    }

    form.addEventListener('submit', () => {
        contentHidden.value = quill.root.innerHTML;
    });
}

function uploadImage(quill, uploadUrl) {
    const fileInput = document.createElement('input');
    fileInput.type = 'file';
    fileInput.accept = 'image/*';
    fileInput.click();

    fileInput.onchange = async () => {
        const file = fileInput.files[0];
        if (!file) return;

        const formData = new FormData();
        formData.append('image', file);
        formData.append('_token', document.querySelector('meta[name="csrf-token"]')?.content ?? '');

        const res = await fetch(uploadUrl, { method: 'POST', body: formData });
        const data = await res.json();

        const range = quill.getSelection(true);
        quill.insertEmbed(range.index, 'image', data.url);
    };
}