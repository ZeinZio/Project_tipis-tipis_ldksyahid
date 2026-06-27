import React, { useState } from "react";
import { CVData } from "../types";
import { motion } from "motion/react";
import { 
  User, Mail, Phone, MapPin, Globe, Github, Linkedin, Briefcase, 
  GraduationCap, Award, ExternalLink, Calendar, Code, CheckCircle,
  Folder, Compass, Star, ArrowUpRight, Search, LayoutGrid, Heart
} from "lucide-react";

interface WebPortfolioProps {
  cvData: CVData;
}

export default function WebPortfolio({ cvData }: WebPortfolioProps) {
  const [selectedCategory, setSelectedCategory] = useState<string>("All");
  const [activeProjectTab, setActiveProjectTab] = useState<string>("All");

  const personal = cvData.personalInfo;

  // Derive unique categories of skills
  const skillCategories = ["All", "Technical", "Soft Skill", "Language"];

  const filteredSkills = selectedCategory === "All" 
    ? cvData.skills 
    : cvData.skills.filter(sk => sk.category === selectedCategory);

  return (
    <div className="bg-[#05070a] text-slate-100 min-h-screen relative overflow-x-hidden font-sans pb-16 selection:bg-emerald-500/30 selection:text-emerald-300" id="portfolio-showcase">
      
      {/* Dynamic Header Vibe of ldksyah.id but polished Sophisticated Dark */}
      <div className="bg-gradient-to-br from-[#0c1b18] to-[#040a08] text-white py-14 px-6 relative overflow-hidden border-b-2 border-emerald-500 shadow-2xl">
        {/* Subtle geometric pattern lines inside banner */}
        <div className="absolute inset-0 opacity-[0.03] pointer-events-none bg-[radial-gradient(#FAF9F5_1px,transparent_1px)] [background-size:16px_16px]"></div>
        <div className="absolute -left-12 -bottom-12 w-48 h-48 rounded-full bg-emerald-900/20 blur-3xl"></div>
        <div className="absolute -right-12 -top-12 w-56 h-56 rounded-full bg-amber-500/10 blur-3xl"></div>

        <div className="max-w-5xl mx-auto flex flex-col md:flex-row items-center gap-8 relative z-10">
          {/* Avatar frame */}
          <motion.div 
            initial={{ scale: 0.9, opacity: 0 }}
            animate={{ scale: 1, opacity: 1 }}
            transition={{ duration: 0.5 }}
            className="w-32 h-32 md:w-36 md:h-36 rounded-full border-4 border-emerald-500 shadow-2xl overflow-hidden flex items-center justify-center bg-[#13161c] text-emerald-400 font-serif font-bold text-4xl shrink-0 tracking-wider relative status-glow"
          >
            <div className="absolute inset-1 rounded-full border-2 border-dotted border-emerald-500/20"></div>
            {personal.fullName ? personal.fullName.split(" ").map(w => w[0]).join("").toUpperCase().slice(0, 2) : "ZR"}
          </motion.div>

          {/* Description & name */}
          <div className="text-center md:text-left flex-1 space-y-2">
            <div className="inline-flex items-center gap-1.5 px-3 py-1 bg-amber-500/10 text-amber-300 font-bold uppercase tracking-wider text-[11px] rounded-full border border-amber-500/30">
              <Star size={11} className="fill-amber-300" /> Digital Portfolio Aktif
            </div>
            <motion.h1 
              initial={{ y: 15, opacity: 0 }}
              animate={{ y: 0, opacity: 1 }}
              transition={{ delay: 0.1, duration: 0.5 }}
              className="text-3xl md:text-4xl font-serif font-bold tracking-tight text-white"
            >
              {personal.fullName || "Zio Raines"}
            </motion.h1>
            <p className="text-emerald-400 font-bold text-md tracking-wide font-mono">
              {personal.title || "Full-stack Developer & Creator"}
            </p>
            
            {/* Quick contact tags */}
            <div className="flex flex-wrap items-center justify-center md:justify-start gap-3 text-xs text-slate-300 font-medium pt-3">
              {personal.location && (
                <span className="flex items-center gap-1 bg-[#13161c]/60 px-3 py-1.5 rounded-lg border border-white/5">
                  <MapPin size={12} className="text-emerald-400" /> {personal.location}
                </span>
              )}
              {personal.email && (
                <span className="flex items-center gap-1 bg-[#13161c]/60 px-3 py-1.5 rounded-lg border border-white/5">
                  <Mail size={12} className="text-emerald-400" /> {personal.email}
                </span>
              )}
              {personal.phone && (
                <span className="flex items-center gap-1 bg-[#13161c]/60 px-3 py-1.5 rounded-lg border border-white/5">
                  <Phone size={12} className="text-emerald-400" /> {personal.phone}
                </span>
              )}
            </div>
          </div>
        </div>
      </div>

      {/* Main Content Layout */}
      <div className="max-w-5xl mx-auto px-4 mt-8 md:px-6">
        <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
          
          {/* Left Column (Sticky Bio / Contacts & Skills) */}
          <div className="lg:col-span-1 space-y-8">
            
            {/* About card with Syahid decorative look */}
            <div className="bg-[#0b0c10] p-6 rounded-2xl shadow-xl border border-white/5 relative overflow-hidden">
              <div className="absolute top-0 right-0 w-16 h-16 bg-emerald-500/5 rounded-bl-full"></div>
              <h3 className="text-white font-bold text-md flex items-center gap-2 mb-4">
                <User size={16} className="text-emerald-400" /> Profil Profesional
              </h3>
              <p className="text-sm text-slate-300 leading-relaxed text-justify font-sans">
                {personal.about || "Tidak ada rincian ringkasan profil ditambahkan."}
              </p>

              {/* Social Channels List with elegant colors */}
              <div className="mt-6 pt-6 border-t border-white/5 space-y-3">
                {personal.website && (
                  <a href={personal.website} target="_blank" rel="noopener noreferrer" className="flex items-center justify-between text-xs text-slate-300 hover:text-emerald-400 font-medium transition-all group">
                    <span className="flex items-center gap-2">
                      <Globe size={14} className="text-emerald-400" /> Situs Web CV
                    </span>
                    <ArrowUpRight size={12} className="opacity-40 group-hover:opacity-100 group-hover:translate-x-0.5" />
                  </a>
                )}
                {personal.github && (
                  <a href={personal.github} target="_blank" rel="noopener noreferrer" className="flex items-center justify-between text-xs text-slate-300 hover:text-emerald-400 font-medium transition-all group">
                    <span className="flex items-center gap-2">
                      <Github size={14} className="text-emerald-400" /> Profil GitHub
                    </span>
                    <ArrowUpRight size={12} className="opacity-40 group-hover:opacity-100 group-hover:translate-x-0.5" />
                  </a>
                )}
                {personal.linkedin && (
                  <a href={personal.linkedin} target="_blank" rel="noopener noreferrer" className="flex items-center justify-between text-xs text-slate-300 hover:text-emerald-400 font-medium transition-all group">
                    <span className="flex items-center gap-2">
                      <Linkedin size={14} className="text-emerald-400" /> Tautan LinkedIn
                    </span>
                    <ArrowUpRight size={12} className="opacity-40 group-hover:opacity-100 group-hover:translate-x-0.5" />
                  </a>
                )}
              </div>
            </div>

            {/* Interactive Filterable Skills with beautiful gold highlights */}
            <div className="bg-[#0b0c10] p-6 rounded-2xl shadow-xl border border-white/5">
              <div className="flex items-center justify-between mb-4">
                <h3 className="text-white font-bold text-md flex items-center gap-2">
                  <Code size={16} className="text-emerald-400" /> Peta Keahlian
                </h3>
              </div>

              {/* Category Filter Chips */}
              <div className="flex flex-wrap gap-1.5 mb-5">
                {skillCategories.map(cat => (
                  <button
                    key={cat}
                    onClick={() => setSelectedCategory(cat)}
                    className={`px-3 py-1 text-[10px] font-bold rounded-lg uppercase tracking-wide transition-all duration-300 pointer-events-auto cursor-pointer ${
                      selectedCategory === cat
                        ? "bg-emerald-600 text-white shadow-md status-glow"
                        : "bg-[#13161c] text-slate-400 hover:bg-[#1c212b] hover:text-white"
                    }`}
                  >
                    {cat === "All" ? "Semua" : cat === "Technical" ? "Teknis" : cat === "Soft Skill" ? "Intrpersnal" : "Bahasa"}
                  </button>
                ))}
              </div>

              {/* Skills Progress Lines */}
              {filteredSkills.length === 0 ? (
                <p className="text-xs text-slate-500">Belum ada skill.</p>
              ) : (
                <div className="space-y-4">
                  {filteredSkills.map((sk, index) => (
                    <div key={index} className="space-y-1">
                      <div className="flex items-center justify-between text-xs">
                        <span className="font-bold text-slate-200">{sk.name}</span>
                        <span className="font-mono text-amber-400 font-bold text-[10px] bg-amber-500/10 px-1.5 py-0.5 rounded border border-amber-500/20">
                          {sk.level}%
                        </span>
                      </div>
                      <div className="w-full h-2 bg-[#13161c] rounded-full overflow-hidden border border-white/5">
                        <motion.div 
                          className="h-full bg-gradient-to-r from-emerald-600 to-amber-500"
                          initial={{ width: 0 }}
                          whileInView={{ width: `${sk.level}%` }}
                          viewport={{ once: true }}
                          transition={{ duration: 1, ease: "easeOut" }}
                        />
                      </div>
                    </div>
                  ))}
                </div>
              )}
            </div>

          </div>

          {/* Right Column (Experience & Projects) */}
          <div className="lg:col-span-2 space-y-8">
            
            {/* Experience Timeline */}
            <div className="bg-[#0b0c10] p-6 rounded-2xl shadow-xl border border-white/5">
              <h3 className="text-white font-bold text-md flex items-center gap-2 mb-6 border-b border-white/5 pb-3">
                <Briefcase size={16} className="text-emerald-400" /> Pengalaman & Kontribusi Karir
              </h3>

              {cvData.workExperience.length === 0 ? (
                <p className="text-sm text-slate-500">Belum ada pengalaman kerja diunggah.</p>
              ) : (
                <div className="relative pl-6 border-l-2 border-emerald-500/20 space-y-8">
                  {cvData.workExperience.map((exp, idx) => (
                    <div key={exp.id || idx} className="relative">
                      {/* Anchor Timeline bullet */}
                      <span className="absolute -left-[31px] top-1.5 w-4 h-4 rounded-full bg-[#0b0c10] border-2 border-emerald-500 flex items-center justify-center text-[10px] text-emerald-450 font-bold status-glow">
                        {idx + 1}
                      </span>

                      <div className="space-y-1.5 animate-fade-in">
                        <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-1">
                          <h4 className="text-sm font-extrabold text-white">{exp.position}</h4>
                          <span className="text-[10px] font-bold text-amber-300 bg-amber-500/10 px-2.5 py-0.5 rounded border border-amber-500/20 self-start sm:self-center flex items-center gap-1 font-mono">
                            <Calendar size={10} /> {exp.period}
                          </span>
                        </div>
                        
                        <div className="text-xs text-slate-400 font-medium">
                          {exp.company} <span className="text-white/20">|</span> {exp.location}
                        </div>

                        <p className="text-xs text-slate-300 leading-relaxed whitespace-pre-line text-justify pl-1 pt-1.5">
                          {exp.description}
                        </p>
                      </div>
                    </div>
                  ))}
                </div>
              )}
            </div>

            {/* Academic Journey */}
            <div className="bg-[#0b0c10] p-6 rounded-2xl shadow-xl border border-white/5">
              <h3 className="text-white font-bold text-md flex items-center gap-2 mb-6 border-b border-white/5 pb-3">
                <GraduationCap size={16} className="text-emerald-400" /> Riwayat Pendidikan
              </h3>

              {cvData.education.length === 0 ? (
                <p className="text-sm text-slate-500">Belum ada riwayat pendidikan diunggah.</p>
              ) : (
                <div className="space-y-6">
                  {cvData.education.map((edu) => (
                    <div key={edu.id} className="flex gap-4 items-start">
                      <div className="p-2.5 bg-[#13161c] rounded-xl border border-white/5 text-emerald-400">
                        <GraduationCap size={20} />
                      </div>
                      <div className="flex-1 space-y-1">
                        <div className="flex flex-col sm:flex-row sm:items-center justify-between">
                          <h4 className="text-sm font-bold text-white">{edu.institution}</h4>
                          <span className="text-[10px] font-mono font-bold text-slate-500">{edu.period}</span>
                        </div>
                        <div className="text-xs text-emerald-400 font-semibold">{edu.degree}</div>
                        {edu.gpa && (
                          <div className="text-[11px] text-amber-350 font-bold bg-amber-500/10 w-max px-2 py-0.5 rounded border border-amber-500/20 mt-1">
                            IPK / GPA: {edu.gpa}
                          </div>
                        )}
                        {edu.description && (
                          <p className="text-xs text-slate-300 mt-2 leading-relaxed text-justify">
                            {edu.description}
                          </p>
                        )}
                      </div>
                    </div>
                  ))}
                </div>
              )}
            </div>

            {/* Dynamic Interactive Projects */}
            <div className="bg-[#0b0c10] p-6 rounded-2xl shadow-xl border border-white/5">
              <h3 className="text-white font-bold text-md flex items-center gap-2 mb-6 border-b border-white/5 pb-3">
                <Folder size={16} className="text-emerald-400" /> Galeri Projek & Inovasi
              </h3>

              {cvData.projects.length === 0 ? (
                <p className="text-sm text-slate-500">Belum ada rincian projek ditambahkan.</p>
              ) : (
                <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                  {cvData.projects.map((proj) => (
                    <motion.div 
                      whileHover={{ y: -3 }}
                      key={proj.id} 
                      className="p-5 rounded-xl border border-white/5 bg-[#13161c]/40 hover:bg-[#13161c]/80 hover:shadow-xl hover:border-emerald-500/20 transition-all flex flex-col justify-between"
                    >
                      <div className="space-y-2">
                        <div className="flex items-center justify-between">
                          <span className="p-1.5 bg-emerald-500/10 text-emerald-400 rounded-lg">
                            <Code size={14} />
                          </span>
                          {proj.link && (
                            <a 
                              href={proj.link} 
                              target="_blank" 
                              rel="noopener noreferrer" 
                              className="text-emerald-400 hover:text-amber-300 text-xs font-bold inline-flex items-center gap-0.5 cursor-pointer"
                            >
                              Demo <ExternalLink size={10} />
                            </a>
                          )}
                        </div>

                        <h4 className="text-sm font-bold text-white mt-1">{proj.title}</h4>
                        <div className="text-[10px] text-amber-300 font-bold uppercase tracking-wider">{proj.role}</div>
                        
                        <p className="text-xs text-slate-350 leading-relaxed text-justify line-clamp-3">
                          {proj.description}
                        </p>
                      </div>

                      {proj.technologies.length > 0 && (
                        <div className="flex flex-wrap gap-1 pt-4 border-t border-white/5 mt-4">
                          {proj.technologies.map((tech, i) => (
                            <span key={i} className="text-[9px] font-bold bg-[#13161c] text-emerald-450 px-1.5 py-0.5 rounded border border-white/5">
                              {tech}
                            </span>
                          ))}
                        </div>
                      )}
                    </motion.div>
                  ))}
                </div>
              )}
            </div>

          </div>
        </div>
      </div>

      {/* Styled Footer inspired by LDK Syahid but Dark */}
      <footer className="mt-14 border-t border-white/5 pt-8 text-center text-xs text-slate-500 max-w-5xl mx-auto px-4">
        <p className="flex items-center justify-center gap-1">
          Portofolio Web yang dihasilkan oleh platform <strong className="text-emerald-400 font-semibold font-serif">"CV Syahid AI"</strong>. Didesain mirip <a href="https://ldksyah.id/" target="_blank" rel="noopener noreferrer" className="hover:underline font-bold text-emerald-400">ldksyah.id</a>.
        </p>
        <p className="mt-1.5">
          Dibuat dengan <Heart size={10} className="inline text-rose-500 fill-rose-500" /> untuk mahasiswa dan talenta muda Indonesia. 
        </p>
      </footer>

    </div>
  );
}
