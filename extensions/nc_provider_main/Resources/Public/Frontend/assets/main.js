const g=(()=>{const l=(e,t)=>{const s=document.getElementById(t);s&&(s.getAttribute("aria-hidden")==="true"?o(s):c(s))},o=e=>{document.querySelectorAll(`.js-disclosure-trigger[aria-controls="${e.id}"]`).forEach(d=>{d.classList.add("is-open"),d.setAttribute("aria-expanded","true")}),e.setAttribute("aria-hidden","false"),e.classList.add("is-open");const s=e.closest(".js-disclosure-list");s&&(s.dataset.disclosureMultiexpand||"true")==="false"&&s.querySelectorAll(".js-disclosure-panel").forEach(u=>{u.id!==e.id&&c(u)})},c=e=>{document.querySelectorAll(`.js-disclosure-trigger[aria-controls="${e.id}"]`).forEach(s=>{s.classList.remove("is-open"),s.setAttribute("aria-expanded","false")}),e.setAttribute("aria-hidden","true"),e.classList.remove("is-open")},n=()=>{const e=document.querySelectorAll(".js-disclosure-panel[data-disclosure-disable-at]");e.length&&e.forEach(function(t){const s=t.getAttribute("data-disclosure-disable-at");window.matchMedia(s).matches?o(t):c(t)})};return{initialize:()=>{if(document.addEventListener("click",e=>{const t=e.target.closest(".js-disclosure-trigger");if(t){e.preventDefault();const s=t.getAttribute("aria-controls");l(t,s)}}),window.location.hash){const e=window.location.hash.replace(/[!"!$&='()*+,./:;<=>?@\[\\\]^`{|}~]/g,"-"),t=document.querySelector(e);t&&t.classList.contains("js-disclosure-panel")&&o(t)}["orientationchange","resize","load"].forEach(e=>{window.addEventListener(e,n)}),n()}}})(),w=(()=>{let l=!1,o=!1,c=0;const n=document.documentElement;let r={mobile:60,desktop:60},e=768;const t=()=>{const i=Math.round(window.scrollY),f=window.innerWidth>=e?r.desktop:r.mobile;if(i>f!==l){l=!l;const a=l?"is-scroll":"is-noScroll",h=new Event(`scrollcheck/${a}`);n.classList.remove(l?"is-noScroll":"is-scroll"),n.classList.add(a),n.dispatchEvent(h)}if(i>c||i===0!==o){o=!o;const a=o?"is-scrollTop":"is-scrollDown",h=new Event(`scrollcheck/${a}`);n.classList.remove(o?"is-scrollDown":"is-scrollTop"),n.dispatchEvent(h)}c=i},s=()=>{window.requestAnimationFrame(t)};return{initialize:(i={})=>{n.classList.add("is-noScroll"),document.addEventListener("scroll",s,!1),window.addEventListener("load",s,!1),window.addEventListener("resize",s,!1),window.addEventListener("orientationchange",s,!1),i.offsetTrigger&&(r={...r,...i.offsetTrigger}),i.windowWidthThreshold&&(e=i.windowWidthThreshold)}}})(),m=(()=>({initialize:()=>{document.documentElement.classList.remove("no-js"),document.documentElement.classList.add("js")}}))();m.initialize();g.initialize();w.initialize({offsetTrigger:{mobile:80,desktop:120},windowWidthThreshold:1024});
