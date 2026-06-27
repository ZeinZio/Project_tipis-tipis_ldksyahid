import React, { useState } from "react";
import { CVData, ATSFeedback } from "../types";
import { 
  Sparkles, CheckCircle2, AlertTriangle, XCircle, BrainCircuit, FileSearch,
  ArrowRight, RefreshCw, Cpu, Check, AlertCircle, Copy, CheckCircle
} from "lucide-react";

interface AIAuditProps {
  cvData: CVData;
  onApplySummary: (newSummary: string) => void;
  onAddSkills: (skillsToAdd: string[]) => void;
}

export default function AIAudit({ cvData, onApplySummary, onAddSkills }: AIAuditProps) {
  const [targetTitle, setTargetTitle] = useState<string>("Full Stack Web Developer");
  const [targetDescription, setTargetDescription] = useState<string>(
    "Kami mencari Full Stack Web Developer berbakat untuk merancang dan mendesain aplikasi web responsif. Keahlian yang diperlukan meliputi React, TypeScript, Node.js, Express, Tailwind CSS, REST API, Git, dan pemahaman dasar pangkalan data PostgreSQL.\n\nTanggung Jawab:\n• Menulis kode yang bersih, terdokumentasi, dan efisien.\n• Mendesain landing page responsif di berbagai perangkat.\n• Mengoptimasi akses basis data.\n• Berkolaborasi dengan tim produk secara gesit."
  );
  
  const [loading, setLoading] = useState<boolean>(false);
  const [loadingStatus, setLoadingStatus] = useState<string>("");
  const [feedback, setFeedback] = useState<ATSFeedback | null>(null);
  const [errorMsg, setErrorMsg] = useState<string>("");
  const [appliedSummary, setAppliedSummary] = useState<boolean>(false);
  const [addedSkillsList, setAddedSkillsList] = useState<string[]>([]);

  const handleAudit = async () => {
    setLoading(true);
    setErrorMsg("");
    setFeedback(null);
    setAppliedSummary(false);
    setAddedSkillsList([]);

    const statuses = [
      "Membaca isi CV dan portofolio...",
      "Menganalisis kecocokan dengan posisi target...",
      "Sistem AI sedang mencocokkan kata kunci penting...",
      "Mengevaluasi kepadatan kata kerja tindakan (Action Verbs)...",
      "Merumuskan saran perbaikan dengan STAR method...",
      "Menyusun ringkasan profil terbaik untuk Anda..."
    ];

    let i = 0;
    setLoadingStatus(statuses[0]);
    const interval = setInterval(() => {
      i = (i + 1) % statuses.length;
      setLoadingStatus(statuses[i]);
    }, 2000);

    try {
      const response = await fetch("/api/ats-check", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          cvData: cvData,
          targetTitle: targetTitle,
          targetDescription: targetDescription
        })
      });

      const data = await response.json();
      
      if (!response.ok) {
        throw new Error(data.error || "Gagal melakukan analisis ATS.");
      }

      setFeedback(data);
    } catch (err) {
      console.error(err);
      setErrorMsg(err instanceof Error ? err.message : "Terjadi kesalahan jaringan.");
    } finally {
      clearInterval(interval);
      setLoading(false);
    }
  };

  const handleApplySummaryText = (text: string) => {
    onApplySummary(text);
    setAppliedSummary(true);
  };

  const handleApplySkill = (skillName: string) => {
    if (!addedSkillsList.includes(skillName)) {
      onAddSkills([skillName]);
      setAddedSkillsList([...addedSkillsList, skillName]);
    }
  };

  return (
    <div className="bg-[#0b0c10] rounded-2xl shadow-2xl border border-white/5 overflow-hidden h-full flex flex-col" id="ai-ats-hub">
      
      {/* Title Header */}
      <div className="bg-black/30 border-b border-white/5 px-6 py-4 flex items-center justify-between shrink-0">
        <div className="flex items-center gap-2">
          <BrainCircuit className="text-emerald-450 status-glow" size={18} />
          <h3 className="font-semibold text-white text-sm font-sans tracking-wide">Pemeriksa Kelayakan ATS (AI Audit)</h3>
        </div>
        <div className="text-[11px] font-bold text-amber-300 bg-amber-500/10 px-2.5 py-1 rounded-full border border-amber-500/30">
          Powered by Gemini AI 2.0
        </div>
      </div>

      {/* Workspace Body */}
      <div className="p-6 flex-1 overflow-y-auto space-y-6 scrollbar-none">
        
        {/* Top input forms */}
        <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
          <div className="md:col-span-1 space-y-4">
            <div>
              <label className="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5">Posisi Target Pekerjaan</label>
              <input
                type="text"
                value={targetTitle}
                onChange={(e) => setTargetTitle(e.target.value)}
                className="w-full px-3.5 py-2 bg-[#13161c] border border-white/10 rounded-xl text-sm text-slate-100 focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-transparent transition-all"
                placeholder="Contoh: Frontend Developer"
              />
            </div>
            <div className="bg-[#13161c]/60 p-4 rounded-xl border border-white/5 text-xs text-slate-350 leading-relaxed text-justify">
              <span className="font-bold text-emerald-400 block mb-1">💡 Tips AI ATS:</span>
              Sistem Applicant Tracking mencari kedekatan kata kunci di CV Anda dengan deskripsi lowongan kerja resmi. Masukkan detail deskripsi di sebelah kanan untuk hasil maksimal.
            </div>
          </div>

          <div className="md:col-span-2">
            <label className="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5">Deskripsi Lowongan Vacancy (Job Description)</label>
            <textarea
              rows={6}
              value={targetDescription}
              onChange={(e) => setTargetDescription(e.target.value)}
              className="w-full p-4 bg-[#13161c] border border-white/10 rounded-xl text-sm text-slate-100 focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-transparent leading-relaxed font-sans"
              placeholder="Jiplak / Paste rincian detail lowongan kerja di sini..."
            />
          </div>
        </div>

        {/* Action Button */}
        <div className="flex justify-center pb-4 border-b border-white/5">
          <button
            onClick={handleAudit}
            disabled={loading}
            className="w-full md:w-auto px-8 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-xl transition-all shadow-lg status-glow flex items-center justify-center gap-2 cursor-pointer disabled:opacity-50"
            id="btn-trigger-ai-audit"
          >
            <Sparkles size={16} /> {loading ? "Menganalisis dengan AI..." : "Analis Kelolosan ATS (Mulai)"}
          </button>
        </div>

        {/* LOADING ANIMATION */}
        {loading && (
          <div className="py-12 text-center space-y-4 max-w-sm mx-auto animate-pulse" id="loading-box">
            <div className="relative w-12 h-12 mx-auto">
              <div className="absolute inset-0 rounded-full border-4 border-white/5 border-t-emerald-500 animate-spin"></div>
            </div>
            <p className="text-sm font-bold text-emerald-400">{loadingStatus}</p>
            <p className="text-xs text-slate-500">Analisis ini mendalam dan umumnya membutuhkan waktu 5-10 detik.</p>
          </div>
        )}

        {/* ERROR BOX */}
        {errorMsg && (
          <div className="p-4 bg-rose-950/20 border border-rose-900/30 rounded-xl text-xs text-rose-300 flex items-start gap-3">
            <AlertCircle className="shrink-0 text-rose-500" size={18} />
            <div>
              <span className="font-bold">Analisis Gagal: </span> {errorMsg}
              <p className="mt-1 text-rose-400/85">Pastikan GEMINI_API_KEY terdaftar dengan benar di rahasia aplikasi Anda.</p>
            </div>
          </div>
        )}

        {/* AUDIT RESULTS OUTcomes */}
        {feedback && (
          <div className="space-y-8" id="ats-audit-results">
            
            {/* 1. Score Tracker Box Grid */}
            <div className="grid grid-cols-2 md:grid-cols-4 gap-4">
              
              {/* Overall Score */}
              <div className="p-5 bg-emerald-500/5 rounded-2xl border border-emerald-500/10 text-center space-y-1 relative overflow-hidden">
                <div className="absolute top-0 left-0 w-full h-1 bg-emerald-500"></div>
                <div className="text-xs font-bold text-emerald-450 uppercase tracking-widest">Skor ATS</div>
                <div className="text-4xl font-extrabold text-emerald-400 mt-1">{feedback.score}<span className="text-xs text-slate-550">/100</span></div>
                <div className="text-[10px] text-slate-400 font-medium">Kecocokan Total</div>
              </div>

              {/* Keyword score */}
              <div className="p-5 bg-amber-500/5 rounded-2xl border border-amber-500/10 text-center space-y-1 relative overflow-hidden">
                <div className="absolute top-0 left-0 w-full h-1 bg-amber-550"></div>
                <div className="text-xs font-bold text-amber-400 uppercase tracking-widest">Kata Kunci</div>
                <div className="text-4xl font-extrabold text-amber-300 mt-1">{feedback.keywordScore}<span className="text-xs text-slate-550">%</span></div>
                <div className="text-[10px] text-slate-400 font-medium font-sans">Kepadatan Kompetensi</div>
              </div>

              {/* Formatting score */}
              <div className="p-5 bg-teal-500/5 rounded-2xl border border-teal-500/10 text-center space-y-1 relative overflow-hidden">
                <div className="absolute top-0 left-0 w-full h-1 bg-[#10b981]"></div>
                <div className="text-xs font-bold text-teal-400 uppercase tracking-widest">Struktur & Format</div>
                <div className="text-4xl font-extrabold text-teal-350 mt-1">{feedback.formattingScore}<span className="text-xs text-slate-550">%</span></div>
                <div className="text-[10px] text-slate-400 font-medium">Keterbacaan Alur</div>
              </div>

              {/* Impact score */}
              <div className="p-5 bg-rose-500/5 rounded-2xl border border-rose-500/10 text-center space-y-1 relative overflow-hidden">
                <div className="absolute top-0 left-0 w-full h-1 bg-rose-500"></div>
                <div className="text-xs font-bold text-rose-400 uppercase tracking-widest">Dampak (STAR)</div>
                <div className="text-4xl font-extrabold text-[#fda4af] mt-1">{feedback.impactScore}<span className="text-xs text-slate-550">%</span></div>
                <div className="text-[10px] text-slate-400 font-medium">Keterukuran Metrik</div>
              </div>

            </div>

            {/* Keyword Analizer Pane */}
            <div className="grid grid-cols-1 md:grid-cols-2 gap-6 bg-[#13161c]/40 p-5 rounded-2xl border border-white/5">
              
              {/* Matched keywords */}
              <div className="space-y-3">
                <h4 className="text-xs font-bold text-emerald-400 uppercase tracking-widest flex items-center gap-1.5">
                  <CheckCircle2 size={14} className="text-emerald-400 status-glow" /> Kata Kunci Cocok ({feedback.matchedKeywords.length})
                </h4>
                {feedback.matchedKeywords.length === 0 ? (
                  <p className="text-xs italic text-slate-500">Tidak ditemukan kata kunci yang cocok.</p>
                ) : (
                  <div className="flex flex-wrap gap-2">
                    {feedback.matchedKeywords.map((kw, i) => (
                      <span key={i} className="text-[11px] font-semibold bg-emerald-500/10 text-emerald-350 border border-emerald-500/20 px-2.5 py-1 rounded-md flex items-center gap-1">
                        <Check size={10} /> {kw}
                      </span>
                    ))}
                  </div>
                )}
              </div>

              {/* Missing keywords */}
              <div className="space-y-3">
                <h4 className="text-xs font-bold text-amber-400 uppercase tracking-widest flex items-center gap-1.5">
                  <AlertCircle size={14} className="text-amber-400" /> Kata Kunci Hilang ({feedback.missingKeywords.length})
                </h4>
                {feedback.missingKeywords.length === 0 ? (
                  <p className="text-xs italic text-slate-500">Semua kata kunci utama telah terpenuhi!</p>
                ) : (
                  <div className="flex flex-wrap gap-2">
                    {feedback.missingKeywords.map((kw, i) => (
                      <span key={i} className="text-[11px] font-semibold bg-rose-500/10 text-rose-350 border border-rose-500/20 px-2.5 py-1 rounded-md">
                        {kw}
                      </span>
                    ))}
                  </div>
                )}
              </div>

            </div>

            {/* Structural compliance evaluation (structureFeedback) */}
            <div className="space-y-3">
              <h4 className="text-xs font-bold text-slate-400 uppercase tracking-widest">Kepatuhan Layout & Struktur CV</h4>
              <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                {feedback.structureFeedback.map((fb, idx) => (
                  <div key={idx} className="p-4 border border-white/5 rounded-xl bg-[#13161c]/40 flex gap-3">
                    {fb.status === "success" && <CheckCircle className="text-emerald-400 shrink-0 mt-0.5" size={16} />}
                    {fb.status === "warning" && <AlertTriangle className="text-amber-400 shrink-0 mt-0.5" size={16} />}
                    {fb.status === "danger" && <XCircle className="text-rose-450 shrink-0 mt-0.5" size={16} />}
                    
                    <div className="space-y-0.5">
                      <div className="text-xs font-bold text-white">{fb.criteria}</div>
                      <p className="text-[11px] text-slate-350 leading-relaxed text-justify">{fb.message}</p>
                    </div>
                  </div>
                ))}
              </div>
            </div>

            {/* STAR Writing Optimizations comparisons table */}
            <div className="space-y-3">
              <h4 className="text-xs font-bold text-slate-400 uppercase tracking-widest">Saran Rekonstruksi Kalimat (Metode STAR)</h4>
              
              {feedback.improvements.length === 0 ? (
                <p className="text-xs text-slate-500">Semua deskripsi pengalaman Anda sudah tertulis dengan baik.</p>
              ) : (
                <div className="space-y-4">
                  {feedback.improvements.map((imp, i) => (
                    <div key={i} className="p-4 rounded-xl border border-white/5 bg-[#13161c]/40 shadow-xl space-y-3">
                      <div className="flex items-center justify-between">
                        <span className="text-[10px] font-bold text-emerald-400 bg-emerald-500/10 px-2 py-0.5 rounded border border-emerald-500/20">
                          Saran di bagian: {imp.section}
                        </span>
                      </div>

                      <div className="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs leading-relaxed">
                        <div className="p-3 bg-rose-950/20 border border-rose-900/30 rounded-lg text-rose-300">
                          <span className="font-bold text-rose-400 block mb-1">❌ Kalimat Asli:</span>
                          "{imp.originalText}"
                        </div>
                        <div className="p-3 bg-emerald-950/20 border border-emerald-900/30 rounded-lg text-emerald-200">
                          <span className="font-bold text-emerald-450 block mb-1">✅ Rekomendasi STAR (Hasil terukur kuantitatif):</span>
                          "{imp.suggestedText}"
                        </div>
                      </div>
                    </div>
                  ))}
                </div>
              )}
            </div>

            {/* Profile Summary Generator with overlap overwrite button */}
            <div className="p-5 bg-gradient-to-br from-[#0c1b18] to-[#040a08] text-white rounded-2xl relative overflow-hidden border border-white/5 shadow-2xl">
              <div className="absolute top-0 right-0 w-24 h-24 bg-amber-500/10 rounded-bl-full pointer-events-none"></div>
              
              <div className="relative z-10 space-y-3">
                <span className="text-[9px] font-bold tracking-widest uppercase bg-amber-500/20 text-amber-300 px-2.5 py-1 rounded-full border border-amber-500/35">
                  Rekomendasi Ringkasan Profil CV
                </span>
                <h4 className="text-md font-bold text-amber-400 font-mono">Tentang Saya (Generated AI)</h4>
                
                <p className="text-xs text-slate-100 leading-relaxed text-justify bg-black/40 p-4 rounded-xl border border-white/5 font-serif italic">
                  "{feedback.summaryRewrite}"
                </p>

                <div className="flex justify-end pt-2">
                  <button
                    onClick={() => handleApplySummaryText(feedback.summaryRewrite)}
                    disabled={appliedSummary}
                    className="flex items-center gap-1.5 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 hover:scale-105 text-white font-bold text-xs rounded-lg transition-all shadow-xl cursor-pointer disabled:bg-emerald-950 disabled:text-emerald-500"
                  >
                    {appliedSummary ? <Check size={14} /> : <ArrowRight size={14} />} 
                    {appliedSummary ? "Berhasil Diterapkan ke Profil" : "Terapkan Ringkasan Ini ke CV"}
                  </button>
                </div>
              </div>
            </div>

            {/* Skills suggestions list */}
            <div className="p-5 bg-[#13161c]/40 border border-white/5 rounded-2xl space-y-4">
              <div className="space-y-1">
                <h4 className="text-xs font-bold text-slate-400 uppercase tracking-widest">Rekomendasi Keahlian Tambahan</h4>
                <p className="text-[11px] text-slate-500">Mencantumkan skill berikut akan melipatgandakan peluang verifikasi sistem rekrutmen perusahaan.</p>
              </div>

              <div className="flex flex-wrap gap-2">
                {feedback.suggestedSkills.map((skName, i) => {
                  const wasAdded = addedSkillsList.includes(skName);
                  return (
                    <button
                      key={i}
                      onClick={() => handleApplySkill(skName)}
                      disabled={wasAdded}
                      className={`px-3 py-1.5 rounded-lg text-xs font-semibold transition-all flex items-center gap-1.5 pointer-events-auto cursor-pointer ${
                        wasAdded 
                          ? "bg-emerald-950/20 text-emerald-500 border border-emerald-900/30" 
                          : "bg-emerald-500/10 hover:bg-emerald-555/20 text-emerald-400 border border-emerald-500/20"
                      }`}
                    >
                      {wasAdded ? <Check size={12} /> : <Sparkles size={12} className="text-amber-400" />}
                      {skName} {!wasAdded && <span className="text-[9px] text-emerald-300 opacity-75">+ Tambah</span>}
                    </button>
                  );
                })}
              </div>
            </div>

          </div>
        )}

      </div>
    </div>
  );
}
