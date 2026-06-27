import React, { useState, useEffect } from "react";
import { CVData } from "./types";
import { initialCVData } from "./data";
import CVForm from "./components/CVForm";
import CVPreview from "./components/CVPreview";
import WebPortfolio from "./components/WebPortfolio";
import AIAudit from "./components/AIAudit";
import { 
  FileText, Layout, Sparkles, Download, Upload, RotateCcw, 
  HelpCircle, CheckCircle2, ChevronRight, Menu, X, Star, Heart
} from "lucide-react";

export default function App() {
  const [cvData, setCvData] = useState<CVData>(initialCVData);
  const [activeWorkspaceTab, setActiveWorkspaceTab] = useState<"builder" | "portfolio" | "audit">("builder");
  const [showBackupAlert, setShowBackupAlert] = useState<boolean>(false);
  const [backupAlertMessage, setBackupAlertMessage] = useState<string>("");
  const [mobileMenuOpen, setMobileMenuOpen] = useState<boolean>(false);

  // Load from local storage on mount
  useEffect(() => {
    const saved = localStorage.getItem("cv_syahid_data");
    if (saved) {
      try {
        setCvData(JSON.parse(saved));
      } catch (e) {
        console.error("Gagal memuat data lokal:", e);
      }
    }
  }, []);

  // Save to local storage on cvData change
  useEffect(() => {
    localStorage.setItem("cv_syahid_data", JSON.stringify(cvData));
  }, [cvData]);

  // Override / Apply summary Rewrite suggestion from AI
  const handleApplySummary = (newSummary: string) => {
    const updated = {
      ...cvData,
      personalInfo: {
        ...cvData.personalInfo,
        about: newSummary,
      },
    };
    setCvData(updated);
    triggerNotification("Ringkasan profil berhasil diperbarui!");
  };

  // Add multiple suggested skills from AI
  const handleAddSkills = (skillsToAdd: string[]) => {
    const existingNames = cvData.skills.map((sk) => sk.name.toLowerCase());
    const newSkills = [...cvData.skills];
    
    skillsToAdd.forEach((skName) => {
      if (!existingNames.includes(skName.toLowerCase())) {
        newSkills.push({
          name: skName,
          level: 80,
          category: "Technical",
        });
      }
    });

    setCvData({
      ...cvData,
      skills: newSkills,
    });
    triggerNotification(`${skillsToAdd.length} Keahlian tambahan berhasil disisipkan ke CV!`);
  };

  // Utilities: Reset to default template
  const handleReset = () => {
    if (window.confirm("Apakah Anda yakin ingin mematikan isi saat ini dan memulihkan template default?")) {
      setCvData(initialCVData);
      triggerNotification("Template awal berhasil dipulihkan!");
    }
  };

  // Utilities: Download JSON Backup
  const handleDownloadBackup = () => {
    const blob = new Blob([JSON.stringify(cvData, null, 2)], { type: "application/json" });
    const url = URL.createObjectURL(blob);
    const a = document.createElement("a");
    a.href = url;
    a.download = `backup_cv_${cvData.personalInfo.fullName.toLowerCase().replace(/\s+/g, "_")}.json`;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
    triggerNotification("Format cadangan JSON berhasil diunduh!");
  };

  // Utilities: Import JSON Backup
  const handleUploadBackup = (e: React.ChangeEvent<HTMLInputElement>) => {
    const file = e.target.files?.[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = (event) => {
      try {
        const parsed = JSON.parse(event.target?.result as string);
        if (parsed && parsed.personalInfo && parsed.skills) {
          setCvData(parsed);
          triggerNotification("Arsip cadangan JSON berhasil diunggah!");
        } else {
          alert("Gagal mengimpor. Format JSON tidak sesuai struktur CVData resmi.");
        }
      } catch (err) {
        alert("Gagal membaca file JSON. Pastikan isi file valid.");
      }
    };
    reader.readAsText(file);
    // Reset file input element
    e.target.value = "";
  };

  const triggerNotification = (msg: string) => {
    setBackupAlertMessage(msg);
    setShowBackupAlert(true);
    setTimeout(() => {
      setShowBackupAlert(false);
    }, 4000);
  };

  return (
    <div className="bg-[#05070a] min-h-screen text-slate-100 flex flex-col font-sans selection:bg-emerald-600 selection:text-white">
      
      {/* Dynamic Floating Toast Notification */}
      {showBackupAlert && (
        <div className="fixed bottom-6 right-6 z-50 bg-[#090d16] border-2 border-emerald-500 text-slate-100 px-5 py-3 rounded-xl shadow-2xl flex items-center gap-3 animate-bounce status-glow">
          <CheckCircle2 className="text-emerald-400 animate-pulse" size={18} />
          <span className="text-xs font-bold font-mono tracking-wide">{backupAlertMessage}</span>
        </div>
      )}

      {/* Main Header styled with Sophisticated Dark accent gradient & borders */}
      <header className="bg-black/40 backdrop-blur-md border-b border-white/5 shadow-lg sticky top-0 z-40 pointer-events-auto">
        <div className="max-w-7xl mx-auto px-4 md:px-6 h-16 flex items-center justify-between">
          
          {/* Logo Frame */}
          <div className="flex items-center gap-3">
            <div className="w-10 h-10 rounded-xl accent-gradient flex items-center justify-center text-white font-extrabold text-lg shadow-inner status-glow hover:scale-105 transition-all">
              ZR
            </div>
            <div>
              <h1 className="text-md md:text-lg font-extrabold tracking-tight flex items-center gap-1.5 uppercase text-white">
                ATSyahid <span className="text-xs font-serif font-bold text-emerald-400 lowercase tracking-normal">cv platform</span>
              </h1>
              <p className="text-[9px] font-mono tracking-wider opacity-60 uppercase text-slate-400">LDK Syahid Design Legacy</p>
            </div>
          </div>

          {/* Desktop Central Navigation Menu Switches */}
          <nav className="hidden md:flex items-center gap-2">
            {[
              { id: "builder", label: "Desain CV & Preview", icon: FileText },
              { id: "portfolio", label: "Web Portofolio", icon: Layout },
              { id: "audit", label: "Kepatuhan AI ATS", icon: Sparkles },
            ].map((tab) => {
              const Icon = tab.icon;
              const isActive = activeWorkspaceTab === tab.id;
              return (
                <button
                  key={tab.id}
                  onClick={() => setActiveWorkspaceTab(tab.id as any)}
                  className={`flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold transition-all duration-300 pointer-events-auto cursor-pointer ${
                    isActive
                      ? "bg-emerald-600 text-white shadow-lg status-glow font-bold border border-emerald-500/30"
                      : "text-slate-400 hover:bg-white/5 hover:text-white"
                  }`}
                  id={`nav-tab-${tab.id}`}
                >
                  <Icon size={14} />
                  {tab.label}
                  {tab.id === "audit" && (
                    <span className="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                  )}
                </button>
              );
            })}
          </nav>

          {/* Right actions (Upload/Download backups) */}
          <div className="hidden md:flex items-center gap-3">
            {/* Import file button */}
            <label className="flex items-center gap-1.5 px-3 py-1.5 bg-white/5 hover:bg-white/10 text-slate-200 rounded-lg text-xs font-bold transition-all border border-white/10 cursor-pointer pointer-events-auto group">
              <Upload size={12} className="group-hover:-translate-y-0.5 transition-all" /> Unggah JSON
              <input
                type="file"
                accept=".json"
                onChange={handleUploadBackup}
                className="hidden"
              />
            </label>

            {/* Export data button */}
            <button
              onClick={handleDownloadBackup}
              className="flex items-center gap-1.5 px-3 py-1.5 bg-emerald-650/10 hover:bg-emerald-650/20 text-emerald-400 rounded-lg text-xs font-bold transition-all border border-emerald-500/20 cursor-pointer pointer-events-auto group"
              title="Unduh file backup CV"
            >
              <Download size={12} className="group-hover:translate-y-0.5 transition-all" /> Simpan Cadangan
            </button>

            {/* Rest template button */}
            <button
              onClick={handleReset}
              className="p-2 hover:bg-white/5 text-slate-450 hover:text-white rounded-lg transition-all cursor-pointer pointer-events-auto"
              title="Kembalikan ke isian default"
            >
              <RotateCcw size={14} />
            </button>
          </div>

          {/* Mobile Hamburguer Toggle */}
          <div className="flex items-center gap-2 md:hidden">
            <button
              onClick={() => setMobileMenuOpen(!mobileMenuOpen)}
              className="p-2 hover:bg-white/5 rounded-lg text-slate-200 transition-all cursor-pointer pointer-events-auto"
            >
              {mobileMenuOpen ? <X size={20} /> : <Menu size={20} />}
            </button>
          </div>

        </div>
      </header>

      {/* Mobile Drawer Menu */}
      {mobileMenuOpen && (
        <div className="bg-[#05070a]/95 backdrop-blur-md border-b border-white/10 text-slate-250 p-4 space-y-4 md:hidden relative z-35 flex flex-col shrink-0 pointer-events-auto animate-fadeIn">
          
          {/* Navigation Items list for mobile */}
          <div className="space-y-1">
            {[
              { id: "builder", label: "Desain CV & Preview", icon: FileText },
              { id: "portfolio", label: "Web Portofolio", icon: Layout },
              { id: "audit", label: "Kepatuhan AI ATS", icon: Sparkles },
            ].map((tab) => {
              const Icon = tab.icon;
              const isActive = activeWorkspaceTab === tab.id;
              return (
                <button
                  key={tab.id}
                  onClick={() => {
                    setActiveWorkspaceTab(tab.id as any);
                    setMobileMenuOpen(false);
                  }}
                  className={`w-full flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold transition-all ${
                    isActive
                      ? "bg-emerald-600 text-white"
                      : "hover:bg-white/5 text-slate-350"
                  }`}
                >
                  <Icon size={14} />
                  {tab.label}
                </button>
              );
            })}
          </div>

          {/* Back up tools list for mobile */}
          <div className="pt-4 border-t border-white/10 space-y-2.5">
            <label className="flex items-center gap-2 px-4 py-2 bg-white/5 hover:bg-white/10 text-slate-200 rounded-xl text-xs font-bold transition-all border border-white/10 cursor-pointer justify-center">
              <Upload size={12} /> Unggah File JSON
              <input
                type="file"
                accept=".json"
                onChange={handleUploadBackup}
                className="hidden"
              />
            </label>

            <button
              onClick={() => {
                handleDownloadBackup();
                setMobileMenuOpen(false);
              }}
              className="w-full flex items-center gap-2 px-4 py-2 bg-emerald-650/10 hover:bg-emerald-650/20 text-emerald-400 rounded-xl text-xs font-bold transition-all border border-emerald-500/20 justify-center cursor-pointer"
            >
              <Download size={12} /> Simpan Cadangan (.json)
            </button>

            <button
              onClick={() => {
                handleReset();
                setMobileMenuOpen(false);
              }}
              className="w-full flex items-center gap-2 px-4 py-2 bg-transparent text-slate-400 hover:text-white justify-center text-xs transition-all cursor-pointer"
            >
              <RotateCcw size={12} /> Pulihkan Default
            </button>
          </div>

        </div>
      )}

      {/* MAIN WORKSPACE WRAPPER */}
      <main className="flex-1 max-w-7xl w-full mx-auto p-4 md:p-6 min-h-0 flex flex-col">
        
        {/* VIEW 1: Builder Grid (Form left, Preview right) */}
        {activeWorkspaceTab === "builder" && (
          <div className="grid grid-cols-1 xl:grid-cols-2 gap-6 flex-1 min-h-[500px]" id="builder-grid-workspace">
            <div className="h-full flex flex-col xl:max-h-[calc(100vh-10rem)]">
              <CVForm cvData={cvData} onChange={setCvData} />
            </div>
            <div className="h-full flex flex-col xl:max-h-[calc(100vh-10rem)]">
              <CVPreview cvData={cvData} />
            </div>
          </div>
        )}

        {/* VIEW 2: Scrollable Online Web Portfolio */}
        {activeWorkspaceTab === "portfolio" && (
          <div className="bg-white rounded-2xl shadow-xl overflow-hidden border border-teal-850/10 min-h-[500px] flex flex-col" id="portfolio-workspace">
            {/* Quick portfolio configuration hint bar */}
            <div className="bg-teal-50 px-6 py-3 border-b border-teal-100 flex items-center justify-between text-xs text-teal-850 shrink-0">
              <span>🌟 Anda sedang mendesain Portofolio Web Interaktif Anda. Isian akan tersinkronisasi otomatis menurut isian profil.</span>
              <span className="font-semibold text-amber-600 font-mono hidden sm:inline">Vibe Inspirasi: ldksyah.id</span>
            </div>
            <div className="flex-1 overflow-y-auto">
              <WebPortfolio cvData={cvData} />
            </div>
          </div>
        )}

        {/* VIEW 3: AI ATS Auditor Hub */}
        {activeWorkspaceTab === "audit" && (
          <div className="flex-1 flex flex-col" id="audit-workspace">
            <AIAudit 
              cvData={cvData} 
              onApplySummary={handleApplySummary} 
              onAddSkills={handleAddSkills} 
            />
          </div>
        )}

      </main>

      {/* General Copyright/Branding bottom line */}
      <footer className="py-4 text-center text-[10px] text-gray-400 shrink-0 select-none pb-5">
        <p>© 2026 ATSyahid Platform. Desain visual terinspirasi dari kearifan digital <a href="https://ldksyah.id/" target="_blank" rel="noopener noreferrer" className="hover:underline text-teal-800 font-bold">LDK Syahid UIN Jakarta</a>.</p>
      </footer>

    </div>
  );
}
