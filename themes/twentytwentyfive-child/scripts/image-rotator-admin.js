document.addEventListener('DOMContentLoaded', () => {
  const input = document.getElementById('ttb-ids');
  const list = document.getElementById('ttb-list');
  const btn = document.getElementById('ttb-select');
  if (!input || !list || !btn) return;

  let frame, dragged;

  const sync = () => {
    input.value = [...list.children].map(li => li.dataset.id).join(',');
  };

  const makeItem = (id, url) => {
    const li = document.createElement('li');
    li.dataset.id = id;
    li.draggable = true;
    li.style.cssText = 'position:relative;cursor:move';
    li.innerHTML =
      `<img src="${url}" alt="" style="display:block;object-fit:cover;width:100px;height:100px">` +
      '<button type="button" class="ttb-remove" aria-label="Remove" style="position:absolute;top:2px;right:2px">&times;</button>';
    return li;
  };

  // The server-rendered items need draggable set too
  list.querySelectorAll('li').forEach(li => (li.draggable = true));

  list.addEventListener('click', e => {
    if (e.target.closest('.ttb-remove')) {
      e.target.closest('li').remove();
      sync();
    }
  });

  list.addEventListener('dragstart', e => { dragged = e.target.closest('li'); });
  list.addEventListener('dragover', e => {
    e.preventDefault();
    const over = e.target.closest('li');
    if (!dragged || !over || over === dragged) return;
    const after = e.clientX > over.getBoundingClientRect().left + over.offsetWidth / 2;
    over.parentNode.insertBefore(dragged, after ? over.nextSibling : over);
  });
  list.addEventListener('dragend', () => { dragged = null; sync(); });

  btn.addEventListener('click', () => {
    if (!frame) {
      frame = wp.media({
        title: 'Select rotator images',
        button: { text: 'Use these images' },
        library: { type: 'image' },
        multiple: 'add',
      });

      frame.on('open', () => {
        const selection = frame.state().get('selection');
        input.value.split(',').filter(Boolean).forEach(id => {
          const att = wp.media.attachment(id);
          att.fetch();
          selection.add(att);
        });
      });

      frame.on('select', () => {
        list.replaceChildren();
        frame.state().get('selection').each(att => {
          const a = att.toJSON();
          list.append(makeItem(a.id, a.sizes?.thumbnail?.url ?? a.url));
        });
        sync();
      });
    }
    frame.open();
  });
});