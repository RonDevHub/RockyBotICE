<div id="donateModal" class="modal fixed inset-0 bg-black/90 backdrop-blur-md hidden items-center justify-center z-50 p-4 transition-all duration-300">
    <div class="trailer-shell bg-zinc-900 w-full max-w-lg rounded-[2rem] shadow-2xl overflow-hidden relative border-2 border-zinc-700 transform transition-transform scale-95 opacity-0 duration-300" id="donateModalContent">
        
        <div class="bg-zinc-800 px-6 py-2 file-tab inline-block mt-6 ml-6">
            <span class="text-[10px] uppercase tracking-widest text-zinc-500 font-sans">Kaffeekasse // Beweismittel</span>
        </div>

        <button class="absolute top-6 right-8 text-zinc-500 hover:text-white transition-colors text-3xl" data-close aria-label="Schließen">&times;</button>

        <div class="p-8 md:p-10">
            <h2 class="text-2xl font-bold text-white mb-4 uppercase italic italic tracking-tighter">
                <span class="text-[var(--ddf-red)]">!</span> Unterstützung erbeten
            </h2>
            <p class="text-zinc-400 mb-8 leading-relaxed text-sm border-l-2 border-zinc-700 pl-4 italic">
                "Justus sagt, wir brauchen mehr Kaffee für die Nachtschicht." – Hilf mit, die Serverkosten für den Bot zu decken.
            </p>
            
            <div class="grid grid-cols-1 gap-4 font-sans">
                <a href="https://www.paypal.com/paypalme/Depressionist1/4,99" target="_blank" 
                   class="flex items-center justify-between p-4 bg-zinc-800 border border-zinc-700 rounded-xl hover:border-[var(--ddf-blue)] transition-all group">
                    <span class="font-bold text-zinc-200">PayPal</span>
                    <span class="text-[var(--ddf-blue)] group-hover:translate-x-1 transition-transform">→</span>
                </a>
                <a href="https://ko-fi.com/U6U31EV2VS" target="_blank" 
                   class="flex items-center justify-between p-4 bg-zinc-800 border border-zinc-700 rounded-xl hover:border-[var(--ddf-red)] transition-all group">
                    <span class="font-bold text-zinc-200">Ko-fi</span>
                    <span class="text-[var(--ddf-red)] group-hover:translate-x-1 transition-transform">→</span>
                </a>
                <a href="https://www.buymeacoffee.com/RonDev" target="_blank" 
                   class="flex items-center justify-between p-4 bg-zinc-800 border border-zinc-700 rounded-xl hover:border-yellow-500 transition-all group">
                    <span class="font-bold text-zinc-200">Buy Me A Coffee</span>
                    <span class="text-yellow-500 group-hover:translate-x-1 transition-transform">→</span>
                </a>
                <a href="https://github.com/sponsors/RonDevHub" target="_blank" 
                   class="flex items-center justify-between p-4 bg-white/5 border border-zinc-700 rounded-xl hover:bg-white/10 transition-all group">
                    <span class="font-bold text-white">GitHub Sponsors</span>
                    <span class="text-white group-hover:translate-x-1 transition-transform">→</span>
                </a>
            </div>
        </div>
    </div>
</div>

<div id="infoModal" class="modal fixed inset-0 bg-black/90 backdrop-blur-md hidden items-center justify-center z-50 p-4 transition-all duration-300">
    <div class="trailer-shell bg-zinc-900 w-full max-w-lg rounded-[2rem] shadow-2xl relative border-2 border-zinc-700 transform transition-transform scale-95 opacity-0 duration-300" id="infoModalContent">
        <button class="absolute top-6 right-8 text-zinc-500 hover:text-white text-3xl" data-close>&times;</button>
        <div class="p-8 md:p-10">
            <div class="bg-zinc-800 px-6 py-2 file-tab inline-block mb-6">
                <span class="text-[10px] uppercase tracking-widest text-zinc-500 font-sans">Archiv // Information</span>
            </div>
            <h2 class="text-2xl font-bold text-white mb-6 uppercase italic italic tracking-tighter">Datenblatt</h2>
            <div class="space-y-4 text-zinc-400 text-sm leading-relaxed border-l-2 border-white pl-4">
                <p>Metadaten-Quelle: <a href="https://dreimetadaten.de" class="text-[var(--ddf-blue)] hover:underline" target="_blank">dreimetadaten.de</a></p>
                <p class="bg-red-950/30 border border-red-900/50 p-3 italic text-[10px] text-red-200 uppercase tracking-tighter">
                    Hinweis: Inoffizielles Fan-Projekt. Keine Verbindung zu Kosmos oder Europa.
                </p>
                <p>Alle Markenrechte liegen bei den jeweiligen Inhabern.</p>
                <div class="pt-4 flex justify-center opacity-70 grayscale hover:grayscale-0 transition-all">
                    <a href="https://commitcloud.net/RonDevHub/RockyBotICE" target="_blank">
                        <img src="https://mini-badges.rondevhub.de/forgejo/RonDevHub/RockyBotICE/release/*/*/de" alt="Release Badge">
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="contactModal" class="modal fixed inset-0 bg-black/90 backdrop-blur-md hidden items-center justify-center z-50 p-4 transition-all duration-300">
    <div class="trailer-shell bg-zinc-900 w-full max-w-lg rounded-[2rem] shadow-2xl relative border-2 border-zinc-700 transform transition-transform scale-95 opacity-0 duration-300" id="contactModalContent">
        <button class="absolute top-6 right-8 text-zinc-500 hover:text-white text-3xl" data-close>&times;</button>
        <div class="p-8 md:p-10 text-center">
            <h2 class="text-2xl font-bold text-white mb-2 uppercase italic italic tracking-tighter text-left">Funkkontakt</h2>
            <p class="text-[10px] text-zinc-600 uppercase tracking-widest mb-8 text-left font-sans">Einsatzzentrale Rocky Beach</p>
            
            <div class="space-y-3 font-sans">
                <a href="https://mail-shield.net/313300b5" onclick="popup=window.open('https://mail-shield.net/313300b5','mailhidepopup','width=580,height=635'); return false;"
                   class="block w-full py-4 bg-zinc-800 border-b-2 border-zinc-700 rounded-xl hover:bg-zinc-700 transition font-bold text-zinc-200">
                   📧 E-Mail Nachricht
                </a>
                <a href="https://matrix.to/#/@rondev:matrix.s3cr.net" target="_blank"
                   class="block w-full py-4 bg-zinc-800 border-b-2 border-zinc-700 rounded-xl hover:bg-zinc-700 transition font-bold text-emerald-500 text-sm">
                   💬 Matrix (Direkt)
                </a>
                <a href="https://matrix.to/#/#RockyBotICE:matrix.s3cr.net" target="_blank"
                   class="block w-full py-4 bg-zinc-800 border-b-2 border-zinc-700 rounded-xl hover:bg-zinc-700 transition font-bold text-emerald-500 text-sm">
                   👥 Matrix (Projekt)
                </a>
                <a href="https://github.com/RonDevHub/RockyBotICE/issues" target="_blank"
                   class="block w-full py-4 bg-zinc-950 border border-zinc-800 rounded-xl hover:border-white transition font-bold text-zinc-500 text-xs uppercase tracking-widest">
                   🛠 Fehlerbericht (GitHub)
                </a>
            </div>
        </div>
    </div>
</div>