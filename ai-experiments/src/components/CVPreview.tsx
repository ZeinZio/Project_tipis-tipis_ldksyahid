import React, { useRef } from "react";
import { CVData } from "../types";
import { Printer, Download, Eye, Mail, Phone, MapPin, Globe, Github, Linkedin } from "lucide-react";

interface CVPreviewProps {
  cvData: CVData;
}

export default function CVPreview({ cvData }: CVPreviewProps) {
  const printRef = useRef<HTMLDivElement>(null);

  const handlePrint = () => {
    // We can print compiling styles
    const printContents = printRef.current?.innerHTML;
    const originalContents = document.body.innerHTML;

    if (!printContents) return;

    // Direct printing via standard window print with CSS configurations
    window.print();
  };

  return (
    <div className="bg-[#0b0c10] rounded-2xl shadow-2xl border border-white/5 overflow-hidden h-full flex flex-col" id="cv-preview-container">
      {/* Header bar and action controls */}
      <div className="bg-black/30 border-b border-white/5 px-6 py-4 flex items-center justify-between shrink-0">
        <div className="flex items-center gap-2">
          <Eye className="text-emerald-400 status-glow" size={18} />
          <h3 className="font-semibold text-white text-sm font-sans tracking-wide">Pratinjau CV (ATS-Friendly PDF)</h3>
        </div>
        <div className="flex items-center gap-2">
          <button
            onClick={handlePrint}
            className="flex items-center gap-1.5 text-xs font-bold bg-emerald-600 hover:bg-emerald-700 hover:scale-105 transition-all text-white rounded-lg px-4 py-2 cursor-pointer shadow-lg status-glow border border-emerald-500/20"
            id="btn-print-cv"
          >
            <Printer size={14} /> Cetak / Unduh PDF
          </button>
        </div>
      </div>

      {/* Preview Scrollable Body - High Contrast Dark Canvas */}
      <div className="flex-1 overflow-y-auto p-4 md:p-8 bg-[#05070a] flex justify-center min-h-0 scrollbar-none">
        {/* Printable Paper Area (A4 structure) */}
        <div 
          ref={printRef}
          className="bg-white text-slate-900 font-sans p-8 md:p-12 w-full max-w-[800px] shadow-2xl border border-white/10 rounded-lg min-h-[950px] overflow-visible select-text text-left print-area relative"
          id="cv-printable-paper"
        >
          {/* Personal Info Header */}
          <div className="border-b-2 border-slate-900 pb-5 mb-5 text-center md:text-left">
            <h1 className="text-3xl font-bold tracking-tight text-slate-900 uppercase">{cvData.personalInfo.fullName || "NAMA LENGKAP"}</h1>
            <p className="text-md font-medium text-teal-800 mt-1 uppercase tracking-wide">{cvData.personalInfo.title || "POSISI / JUDUL PROFESIONAL"}</p>
            
            {/* Contact Details Line */}
            <div className="flex flex-wrap items-center justify-center md:justify-start gap-y-2 gap-x-4 mt-3.5 text-xs text-slate-700 font-medium">
              {cvData.personalInfo.email && (
                <span className="flex items-center gap-1">
                  <Mail size={12} className="text-slate-500" />
                  {cvData.personalInfo.email}
                </span>
              )}
              {cvData.personalInfo.phone && (
                <span className="flex items-center gap-1">
                  <Phone size={12} className="text-slate-500" />
                  {cvData.personalInfo.phone}
                </span>
              )}
              {cvData.personalInfo.location && (
                <span className="flex items-center gap-1">
                  <MapPin size={12} className="text-slate-500" />
                  {cvData.personalInfo.location}
                </span>
              )}
            </div>

            {/* Links Line */}
            <div className="flex flex-wrap items-center justify-center md:justify-start gap-y-1 gap-x-4 mt-2 text-[11px] text-slate-500 font-mono">
              {cvData.personalInfo.website && (
                <span className="flex items-center gap-1">
                  <Globe size={11} /> {cvData.personalInfo.website}
                </span>
              )}
              {cvData.personalInfo.github && (
                <span className="flex items-center gap-1">
                  <Github size={11} /> {cvData.personalInfo.github}
                </span>
              )}
              {cvData.personalInfo.linkedin && (
                <span className="flex items-center gap-1">
                  <Linkedin size={11} /> {cvData.personalInfo.linkedin}
                </span>
              )}
            </div>
          </div>

          {/* About Summary Section */}
          {cvData.personalInfo.about && (
            <div className="mb-6">
              <h2 className="text-sm font-bold tracking-wider text-slate-900 uppercase border-b border-slate-300 pb-1 mb-2">Ringkasan Profil</h2>
              <p className="text-xs text-slate-800 leading-relaxed text-justify whitespace-pre-line">
                {cvData.personalInfo.about}
              </p>
            </div>
          )}

          {/* Work Experience Section */}
          {cvData.workExperience.length > 0 && (
            <div className="mb-6">
              <h2 className="text-sm font-bold tracking-wider text-slate-900 uppercase border-b border-slate-300 pb-1 mb-3">Pengalaman Profesional</h2>
              <div className="space-y-4">
                {cvData.workExperience.map((exp) => (
                  <div key={exp.id} className="text-slate-900">
                    <div className="flex flex-col sm:flex-row sm:items-center justify-between font-bold text-xs">
                      <span className="text-[13px]">{exp.position || "Jabatan"}</span>
                      <span className="text-slate-600 font-medium sm:font-bold">{exp.period || "Periode"}</span>
                    </div>
                    <div className="flex flex-col sm:flex-row sm:items-center justify-between text-xs italic text-slate-700 mt-0.5">
                      <span>{exp.company || "Nama Perusahaan"}</span>
                      {exp.location && <span>{exp.location}</span>}
                    </div>
                    {exp.description && (
                      <p className="text-xs text-slate-800 leading-relaxed mt-2 whitespace-pre-line text-justify pl-1">
                        {exp.description}
                      </p>
                    )}
                  </div>
                ))}
              </div>
            </div>
          )}

          {/* Education Section */}
          {cvData.education.length > 0 && (
            <div className="mb-6">
              <h2 className="text-sm font-bold tracking-wider text-slate-900 uppercase border-b border-slate-300 pb-1 mb-3">Pendidikan</h2>
              <div className="space-y-4">
                {cvData.education.map((edu) => (
                  <div key={edu.id}>
                    <div className="flex flex-col sm:flex-row sm:items-center justify-between font-bold text-xs">
                      <span className="text-[13px]">{edu.institution || "Universitas"}</span>
                      <span className="text-slate-600 font-medium sm:font-bold">{edu.period || "Periode"}</span>
                    </div>
                    <div className="flex flex-col sm:flex-row sm:items-center justify-between text-xs text-slate-700 mt-0.5 font-medium">
                      <span>{edu.degree || "Gelar"}</span>
                      {edu.gpa && <span className="font-semibold text-teal-800">IPK: {edu.gpa}</span>}
                    </div>
                    {edu.description && (
                      <p className="text-xs text-slate-700 mt-1 pl-1 text-[11px] leading-relaxed text-justify">
                        {edu.description}
                      </p>
                    )}
                  </div>
                ))}
              </div>
            </div>
          )}

          {/* Projects Section */}
          {cvData.projects.length > 0 && (
            <div className="mb-6">
              <h2 className="text-sm font-bold tracking-wider text-slate-900 uppercase border-b border-slate-300 pb-1 mb-3">Projek & Portofolio</h2>
              <div className="space-y-3">
                {cvData.projects.map((proj) => (
                  <div key={proj.id}>
                    <div className="flex flex-col sm:flex-row sm:items-center justify-between font-bold text-xs">
                      <span className="text-[12px]">{proj.title || "Judul Projek"} | <span className="text-slate-600 font-medium italic">{proj.role}</span></span>
                      {proj.link && (
                        <span className="text-slate-500 font-mono text-[10px] break-all max-w-[250px] truncate">{proj.link}</span>
                      )}
                    </div>
                    {proj.technologies.length > 0 && (
                      <div className="text-[10px] text-teal-800 font-bold tracking-wide mt-0.5 uppercase">
                        Teknologi: {proj.technologies.join(", ")}
                      </div>
                    )}
                    {proj.description && (
                      <p className="text-xs text-slate-800 leading-relaxed mt-1 text-justify pl-1">
                        {proj.description}
                      </p>
                    )}
                  </div>
                ))}
              </div>
            </div>
          )}

          {/* Skills Section (Plain text standard list for ATS) */}
          {cvData.skills.length > 0 && (
            <div className="mb-4">
              <h2 className="text-sm font-bold tracking-wider text-slate-900 uppercase border-b border-slate-300 pb-1 mb-2">Keahlian & Kompetensi</h2>
              <div className="flex flex-wrap gap-x-6 gap-y-1.5 mt-2">
                {["Technical", "Soft Skill", "Language"].map((cat) => {
                  const catSkills = cvData.skills.filter((sk) => sk.category === cat);
                  if (catSkills.length === 0) return null;
                  return (
                    <div key={cat} className="text-xs">
                      <span className="font-bold text-slate-900 uppercase">{cat === "Technical" ? "Hard Skills" : cat === "Soft Skill" ? "Soft Skills" : "Bahasa"}: </span>
                      <span className="text-slate-800">
                        {catSkills.map((sk) => sk.name).join(", ")}
                      </span>
                    </div>
                  );
                })}
              </div>
            </div>
          )}
        </div>
      </div>
    </div>
  );
}
