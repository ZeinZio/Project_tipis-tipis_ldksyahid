import React, { useState } from "react";
import { CVData, WorkExperience, Education, Skill, Project } from "../types";
import { 
  User, Briefcase, GraduationCap, Code, FolderGit, Plus, Trash2, 
  HelpCircle, Link, Mail, Phone, MapPin, Globe, Github, Linkedin, Award,
  Info
} from "lucide-react";

interface CVFormProps {
  cvData: CVData;
  onChange: (newData: CVData) => void;
}

export default function CVForm({ cvData, onChange }: CVFormProps) {
  const [activeTab, setActiveTab] = useState<"personal" | "experience" | "education" | "skills" | "projects">("personal");

  // Handle personal info change
  const handlePersonalChange = (key: keyof typeof cvData.personalInfo, value: string) => {
    onChange({
      ...cvData,
      personalInfo: {
        ...cvData.personalInfo,
        [key]: value,
      },
    });
  };

  // Work experience methods
  const addExperience = () => {
    const newExp: WorkExperience = {
      id: `work-${Date.now()}`,
      position: "",
      company: "",
      period: "",
      location: "",
      description: "• Masukkan pencapaian atau tanggung jawab utama Anda di sini.\n• Mulai kalimat dengan kata kerja aktivitas kuat (misal: Mengelola, Meningkatkan, Merancang).\n• Masukkan metrik angka jika ada (misal: Meningkatkan efisiensi 20%).",
    };
    onChange({
      ...cvData,
      workExperience: [...cvData.workExperience, newExp],
    });
  };

  const updateExperience = (id: string, key: keyof WorkExperience, value: string) => {
    onChange({
      ...cvData,
      workExperience: cvData.workExperience.map((exp) => 
        exp.id === id ? { ...exp, [key]: value } : exp
      ),
    });
  };

  const removeExperience = (id: string) => {
    onChange({
      ...cvData,
      workExperience: cvData.workExperience.filter((exp) => exp.id !== id),
    });
  };

  // Education methods
  const addEducation = () => {
    const newEdu: Education = {
      id: `edu-${Date.now()}`,
      institution: "",
      degree: "",
      period: "",
      gpa: "",
      description: "",
    };
    onChange({
      ...cvData,
      education: [...cvData.education, newEdu],
    });
  };

  const updateEducation = (id: string, key: keyof Education, value: string) => {
    onChange({
      ...cvData,
      education: cvData.education.map((edu) => 
        edu.id === id ? { ...edu, [key]: value } : edu
      ),
    });
  };

  const removeEducation = (id: string) => {
    onChange({
      ...cvData,
      education: cvData.education.filter((edu) => edu.id !== id),
    });
  };

  // Skills methods
  const addSkill = () => {
    const newSkill: Skill = {
      name: "",
      level: 80,
      category: "Technical",
    };
    onChange({
      ...cvData,
      skills: [...cvData.skills, newSkill],
    });
  };

  const updateSkill = (index: number, key: keyof Skill, value: string | number) => {
    const updatedSkills = [...cvData.skills];
    updatedSkills[index] = {
      ...updatedSkills[index],
      [key]: value,
    };
    onChange({
      ...cvData,
      skills: updatedSkills,
    });
  };

  const removeSkill = (index: number) => {
    onChange({
      ...cvData,
      skills: cvData.skills.filter((_, idx) => idx !== index),
    });
  };

  // Projects methods
  const addProject = () => {
    const newProj: Project = {
      id: `proj-${Date.now()}`,
      title: "",
      role: "",
      description: "",
      technologies: [],
      link: "",
    };
    onChange({
      ...cvData,
      projects: [...cvData.projects, newProj],
    });
  };

  const updateProject = (id: string, key: keyof Project, value: any) => {
    onChange({
      ...cvData,
      projects: cvData.projects.map((proj) => 
        proj.id === id ? { ...proj, [key]: value } : proj
      ),
    });
  };

  const removeProject = (id: string) => {
    onChange({
      ...cvData,
      projects: cvData.projects.filter((proj) => proj.id !== id),
    });
  };

  return (
    <div className="bg-[#0b0c10] rounded-2xl shadow-2xl border border-white/5 overflow-hidden h-full flex flex-col" id="cv-form-container">
      {/* Tab Navigation */}
      <div className="flex border-b border-white/5 bg-black/30 p-2 gap-1 overflow-x-auto shrink-0 scrollbar-none">
        {[
          { id: "personal", label: "Profil", icon: User },
          { id: "experience", label: "Pengalaman", icon: Briefcase },
          { id: "education", label: "Pendidikan", icon: GraduationCap },
          { id: "skills", label: "Keahlian", icon: Code },
          { id: "projects", label: "Projek", icon: FolderGit },
        ].map((tab) => {
          const Icon = tab.icon;
          const isActive = activeTab === tab.id;
          return (
            <button
              key={tab.id}
              onClick={() => setActiveTab(tab.id as any)}
              className={`flex items-center gap-2 px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-300 pointer-events-auto shrink-0 ${
                isActive
                  ? "bg-emerald-600 text-white shadow-md shadow-emerald-500/10 border border-emerald-500/20"
                  : "text-slate-400 hover:bg-white/5 hover:text-slate-200"
              }`}
              id={`tab-btn-${tab.id}`}
            >
              <Icon size={16} />
              {tab.label}
            </button>
          );
        })}
      </div>

      {/* Editor Body */}
      <div className="p-6 flex-1 overflow-y-auto min-h-0 space-y-6 scrollbar-none">
        {/* PERSONAL PROFILE */}
        {activeTab === "personal" && (
          <div className="space-y-4" id="form-section-personal">
            <div className="flex items-center gap-2 pb-2 border-b border-white/5">
              <span className="p-1.5 bg-emerald-500/10 text-emerald-400 rounded">
                <User size={18} />
              </span>
              <h3 className="font-semibold text-white text-lg">Informasi Pribadi</h3>
            </div>

            <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label className="block text-xs font-semibold text-slate-400 tracking-wider uppercase mb-1">Nama Lengkap</label>
                <div className="relative">
                  <input
                    type="text"
                    value={cvData.personalInfo.fullName}
                    onChange={(e) => handlePersonalChange("fullName", e.target.value)}
                    className="w-full pl-3 pr-3 py-2 bg-[#13161c] border border-white/10 rounded-lg text-sm text-slate-100 focus:outline-none focus:ring-2 focus:ring-emerald-550/30 focus:border-transparent transition-all placeholder-slate-600"
                    placeholder="Contoh: Zio Raines"
                  />
                </div>
              </div>

              <div>
                <label className="block text-xs font-semibold text-slate-400 tracking-wider uppercase mb-1">Judul Profesional</label>
                <div className="relative">
                  <input
                    type="text"
                    value={cvData.personalInfo.title}
                    onChange={(e) => handlePersonalChange("title", e.target.value)}
                    className="w-full pl-3 pr-3 py-2 bg-[#13161c] border border-white/10 rounded-lg text-sm text-slate-100 focus:outline-none focus:ring-2 focus:ring-emerald-550/30 focus:border-transparent transition-all placeholder-slate-600"
                    placeholder="Contoh: Frontend Engineer / Digital Marketer"
                  />
                </div>
              </div>

              <div>
                <label className="block text-xs font-semibold text-slate-400 tracking-wider uppercase mb-1">Email</label>
                <div className="relative flex items-center">
                  <Mail size={16} className="absolute left-3 text-slate-500" />
                  <input
                    type="email"
                    value={cvData.personalInfo.email}
                    onChange={(e) => handlePersonalChange("email", e.target.value)}
                    className="w-full pl-10 pr-3 py-2 bg-[#13161c] border border-white/10 rounded-lg text-sm text-slate-100 focus:outline-none focus:ring-2 focus:ring-emerald-550/30 focus:border-transparent transition-all placeholder-slate-600"
                    placeholder="email@example.com"
                  />
                </div>
              </div>

              <div>
                <label className="block text-xs font-semibold text-slate-400 tracking-wider uppercase mb-1">Nomor Telepon</label>
                <div className="relative flex items-center">
                  <Phone size={16} className="absolute left-3 text-slate-500" />
                  <input
                    type="text"
                    value={cvData.personalInfo.phone}
                    onChange={(e) => handlePersonalChange("phone", e.target.value)}
                    className="w-full pl-10 pr-3 py-2 bg-[#13161c] border border-white/10 rounded-lg text-sm text-slate-100 focus:outline-none focus:ring-2 focus:ring-emerald-550/30 focus:border-transparent transition-all placeholder-slate-600"
                    placeholder="+62 8123-..."
                  />
                </div>
              </div>

              <div className="md:col-span-2">
                <label className="block text-xs font-semibold text-slate-400 tracking-wider uppercase mb-1">Lokasi</label>
                <div className="relative flex items-center">
                  <MapPin size={16} className="absolute left-3 text-slate-500" />
                  <input
                    type="text"
                    value={cvData.personalInfo.location}
                    onChange={(e) => handlePersonalChange("location", e.target.value)}
                    className="w-full pl-10 pr-3 py-2 bg-[#13161c] border border-white/10 rounded-lg text-sm text-slate-100 focus:outline-none focus:ring-2 focus:ring-emerald-550/30 focus:border-transparent transition-all placeholder-slate-600"
                    placeholder="Jakarta, Indonesia"
                  />
                </div>
              </div>

              <div>
                <label className="block text-xs font-semibold text-slate-400 tracking-wider uppercase mb-1">Situs Web / Portofolio</label>
                <div className="relative flex items-center">
                  <Globe size={16} className="absolute left-3 text-slate-500" />
                  <input
                    type="text"
                    value={cvData.personalInfo.website}
                    onChange={(e) => handlePersonalChange("website", e.target.value)}
                    className="w-full pl-10 pr-3 py-2 bg-[#13161c] border border-white/10 rounded-lg text-sm text-slate-100 focus:outline-none focus:ring-2 focus:ring-emerald-550/30 focus:border-transparent transition-all placeholder-slate-600"
                    placeholder="https://..."
                  />
                </div>
              </div>

              <div>
                <label className="block text-xs font-semibold text-slate-400 tracking-wider uppercase mb-1">GitHub</label>
                <div className="relative flex items-center">
                  <Github size={16} className="absolute left-3 text-slate-500" />
                  <input
                    type="text"
                    value={cvData.personalInfo.github}
                    onChange={(e) => handlePersonalChange("github", e.target.value)}
                    className="w-full pl-10 pr-3 py-2 bg-[#13161c] border border-white/10 rounded-lg text-sm text-slate-100 focus:outline-none focus:ring-2 focus:ring-emerald-550/30 focus:border-transparent transition-all placeholder-slate-600"
                    placeholder="github.com/..."
                  />
                </div>
              </div>

              <div className="md:col-span-2">
                <label className="block text-xs font-semibold text-slate-400 tracking-wider uppercase mb-1">LinkedIn</label>
                <div className="relative flex items-center">
                  <Linkedin size={16} className="absolute left-3 text-slate-500" />
                  <input
                    type="text"
                    value={cvData.personalInfo.linkedin}
                    onChange={(e) => handlePersonalChange("linkedin", e.target.value)}
                    className="w-full pl-10 pr-3 py-2 bg-[#13161c] border border-white/10 rounded-lg text-sm text-slate-100 focus:outline-none focus:ring-2 focus:ring-emerald-550/30 focus:border-transparent transition-all placeholder-slate-600"
                    placeholder="linkedin.com/in/..."
                  />
                </div>
              </div>

              <div className="md:col-span-2">
                <div className="flex items-center justify-between mb-1">
                  <label className="block text-xs font-semibold text-slate-400 tracking-wider uppercase text-slate-450">
                    Tentang Saya (Ringkasan Profil)
                  </label>
                  <span className="text-[10px] text-slate-500 font-medium flex items-center gap-0.5">
                    <Info size={10} /> ATS menyukai ringkasan padat kata kunci tindakan!
                  </span>
                </div>
                <textarea
                  rows={4}
                  value={cvData.personalInfo.about}
                  onChange={(e) => handlePersonalChange("about", e.target.value)}
                  className="w-full p-3 bg-[#13161c] border border-white/10 rounded-lg text-sm text-slate-100 focus:outline-none focus:ring-2 focus:ring-emerald-550/30 focus:border-transparent transition-all font-sans leading-relaxed placeholder-slate-650"
                  placeholder="Ceritakan sejarah karir, pencapaian dan keahlian inti Anda..."
                />
              </div>
            </div>
          </div>
        )}

        {/* WORK EXPERIENCE */}
        {activeTab === "experience" && (
          <div className="space-y-4" id="form-section-experience">
            <div className="flex items-center justify-between pb-2 border-b border-white/5">
              <div className="flex items-center gap-2">
                <span className="p-1.5 bg-emerald-500/10 text-emerald-400 rounded">
                  <Briefcase size={18} />
                </span>
                <h3 className="font-semibold text-white text-lg">Pengalaman Kerja</h3>
              </div>
              <button
                onClick={addExperience}
                className="flex items-center gap-1.5 text-xs font-semibold bg-emerald-600 hover:bg-emerald-700 text-white transition-all rounded-lg px-3 py-1.5 cursor-pointer shadow-sm hover:scale-105"
              >
                <Plus size={14} /> Tambah Kerja
              </button>
            </div>

            {cvData.workExperience.length === 0 ? (
              <div className="text-center py-8 bg-[#13161c]/30 rounded-xl border border-dashed border-white/5">
                <Briefcase className="mx-auto text-slate-600 mb-2" size={32} />
                <p className="text-sm text-slate-400">Belum ada pengalaman kerja ditambahkan.</p>
                <button
                  onClick={addExperience}
                  className="mt-3 text-xs font-semibold text-emerald-450 hover:underline inline-flex items-center gap-1 cursor-pointer"
                >
                  <Plus size={14} /> Tambah Sekarang
                </button>
              </div>
            ) : (
              <div className="space-y-6">
                {cvData.workExperience.map((exp, index) => (
                  <div key={exp.id} className="relative p-5 border border-white/5 rounded-xl bg-[#13161c]/40 space-y-4 shadow-sm hover:border-emerald-500/20 transition-all">
                    <button
                      onClick={() => removeExperience(exp.id)}
                      className="absolute top-4 right-4 text-slate-500 hover:text-rose-450 transition-all cursor-pointer p-1 rounded-md hover:bg-rose-950/20"
                      title="Hapus Pengalaman"
                    >
                      <Trash2 size={16} />
                    </button>

                    <div className="text-xs font-bold text-emerald-400 bg-emerald-500/10 px-2 py-0.5 rounded w-max">
                      Pengalaman {index + 1}
                    </div>

                    <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                      <div>
                        <label className="block text-xs font-semibold text-slate-400 tracking-wider uppercase mb-1">Posisi / Jabatan</label>
                        <input
                          type="text"
                          value={exp.position}
                          onChange={(e) => updateExperience(exp.id, "position", e.target.value)}
                          className="w-full px-3 py-1.5 bg-[#13161c] border border-white/10 rounded-lg text-sm text-slate-100 focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-transparent transition-all placeholder-slate-600"
                          placeholder="Contoh: Software Engineer Intern"
                        />
                      </div>
                      <div>
                        <label className="block text-xs font-semibold text-slate-400 tracking-wider uppercase mb-1">Perusahaan / Institusi</label>
                        <input
                          type="text"
                          value={exp.company}
                          onChange={(e) => updateExperience(exp.id, "company", e.target.value)}
                          className="w-full px-3 py-1.5 bg-[#13161c] border border-white/10 rounded-lg text-sm text-slate-100 focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-transparent transition-all placeholder-slate-600"
                          placeholder="PT Digital Solusi"
                        />
                      </div>
                      <div>
                        <label className="block text-xs font-semibold text-slate-400 tracking-wider uppercase mb-1">Periode Waktu</label>
                        <input
                          type="text"
                          value={exp.period}
                          onChange={(e) => updateExperience(exp.id, "period", e.target.value)}
                          className="w-full px-3 py-1.5 bg-[#13161c] border border-white/10 rounded-lg text-sm text-slate-100 focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-transparent transition-all placeholder-slate-600"
                          placeholder="Jan 2024 - Sekarang atau 2022 - 2023"
                        />
                      </div>
                      <div>
                        <label className="block text-xs font-semibold text-slate-400 tracking-wider uppercase mb-1">Lokasi</label>
                        <input
                          type="text"
                          value={exp.location}
                          onChange={(e) => updateExperience(exp.id, "location", e.target.value)}
                          className="w-full px-3 py-1.5 bg-[#13161c] border border-white/10 rounded-lg text-sm text-slate-100 focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-transparent transition-all placeholder-slate-600"
                          placeholder="Jakarta / Tangerang, Banten"
                        />
                      </div>

                      <div className="md:col-span-2">
                        <div className="flex items-center justify-between mb-1">
                          <label className="block text-xs font-semibold text-slate-400 tracking-wider uppercase">
                            Deskripsi Pekerjaan & Pencapaian
                          </label>
                          <span className="text-[10px] text-slate-500 font-medium">Gunakan tanda '•' untuk bullet-points</span>
                        </div>
                        <textarea
                          rows={4}
                          value={exp.description}
                          onChange={(e) => updateExperience(exp.id, "description", e.target.value)}
                          className="w-full p-3 bg-[#13161c] border border-white/10 rounded-lg text-sm text-slate-100 focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-transparent transition-all font-mono leading-relaxed placeholder-slate-650"
                          placeholder="• Tulis tanggung jawab utama Anda..."
                        />
                      </div>
                    </div>
                  </div>
                ))}
              </div>
            )}
          </div>
        )}

        {/* EDUCATION */}
        {activeTab === "education" && (
          <div className="space-y-4" id="form-section-education">
            <div className="flex items-center justify-between pb-2 border-b border-white/5">
              <div className="flex items-center gap-2">
                <span className="p-1.5 bg-emerald-500/10 text-emerald-400 rounded">
                  <GraduationCap size={18} />
                </span>
                <h3 className="font-semibold text-white text-lg">Riwayat Pendidikan</h3>
              </div>
              <button
                onClick={addEducation}
                className="flex items-center gap-1.5 text-xs font-semibold bg-emerald-600 hover:bg-emerald-700 text-white transition-all rounded-lg px-3 py-1.5 cursor-pointer shadow-sm"
              >
                <Plus size={14} /> Tambah Pendidikan
              </button>
            </div>

            {cvData.education.length === 0 ? (
              <div className="text-center py-8 bg-[#13161c]/30 rounded-xl border border-dashed border-white/5">
                <GraduationCap className="mx-auto text-slate-600 mb-2" size={32} />
                <p className="text-sm text-slate-400">Belum ada riwayat pendidikan ditambahkan.</p>
                <button
                  onClick={addEducation}
                  className="mt-3 text-xs font-semibold text-emerald-450 hover:underline inline-flex items-center gap-1 cursor-pointer"
                >
                  <Plus size={14} /> Tambah Sekarang
                </button>
              </div>
            ) : (
              <div className="space-y-6">
                {cvData.education.map((edu, index) => (
                  <div key={edu.id} className="relative p-5 border border-white/5 rounded-xl bg-[#13161c]/40 space-y-4 shadow-sm hover:border-emerald-500/20 transition-all">
                    <button
                      onClick={() => removeEducation(edu.id)}
                      className="absolute top-4 right-4 text-slate-500 hover:text-rose-450 transition-all cursor-pointer p-1 rounded-md hover:bg-rose-950/20"
                      title="Hapus Pendidikan"
                    >
                      <Trash2 size={16} />
                    </button>

                    <div className="text-xs font-bold text-emerald-400 bg-emerald-500/10 px-2 py-0.5 rounded w-max">
                      Pendidikan {index + 1}
                    </div>

                    <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                      <div>
                        <label className="block text-xs font-semibold text-slate-400 tracking-wider uppercase mb-1">Sekolah / Universitas</label>
                        <input
                          type="text"
                          value={edu.institution}
                          onChange={(e) => updateEducation(edu.id, "institution", e.target.value)}
                          className="w-full px-3 py-1.5 bg-[#13161c] border border-white/10 rounded-lg text-sm text-slate-100 focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-transparent transition-all placeholder-slate-600"
                          placeholder="UIN Syarif Hidayatullah Jakarta"
                        />
                      </div>
                      <div>
                        <label className="block text-xs font-semibold text-slate-400 tracking-wider uppercase mb-1">Gelar & Program Studi</label>
                        <input
                          type="text"
                          value={edu.degree}
                          onChange={(e) => updateEducation(edu.id, "degree", e.target.value)}
                          className="w-full px-3 py-1.5 bg-[#13161c] border border-white/10 rounded-lg text-sm text-slate-100 focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-transparent transition-all placeholder-slate-600"
                          placeholder="S1 Teknik Informatika"
                        />
                      </div>
                      <div>
                        <label className="block text-xs font-semibold text-slate-400 tracking-wider uppercase mb-1">Periode Belajar</label>
                        <input
                          type="text"
                          value={edu.period}
                          onChange={(e) => updateEducation(edu.id, "period", e.target.value)}
                          className="w-full px-3 py-1.5 bg-[#13161c] border border-white/10 rounded-lg text-sm text-slate-100 focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-transparent transition-all placeholder-slate-600"
                          placeholder="2022 - Sekarang atau 2018 - 2022"
                        />
                      </div>
                      <div>
                        <label className="block text-xs font-semibold text-slate-400 tracking-wider uppercase mb-1">IPK / GPA (Opsional)</label>
                        <input
                          type="text"
                          value={edu.gpa}
                          onChange={(e) => updateEducation(edu.id, "gpa", e.target.value)}
                          className="w-full px-3 py-1.5 bg-[#13161c] border border-white/10 rounded-lg text-sm text-slate-100 focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-transparent transition-all placeholder-slate-600"
                          placeholder="3.85 / 4.00"
                        />
                      </div>
                      <div className="md:col-span-2">
                        <label className="block text-xs font-semibold text-slate-400 tracking-wider uppercase mb-1">Aktivitas & Keterangan Tambahan</label>
                        <textarea
                          rows={2}
                          value={edu.description}
                          onChange={(e) => updateEducation(edu.id, "description", e.target.value)}
                          className="w-full p-3 bg-[#13161c] border border-white/10 rounded-lg text-sm text-slate-100 focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-transparent transition-all leading-relaxed placeholder-slate-650"
                          placeholder="Prestasi, kepanitiaan, atau proyek akademik khusus..."
                        />
                      </div>
                    </div>
                  </div>
                ))}
              </div>
            )}
          </div>
        )}

        {/* SKILLS */}
        {activeTab === "skills" && (
          <div className="space-y-4" id="form-section-skills">
            <div className="flex items-center justify-between pb-2 border-b border-white/5">
              <div className="flex items-center gap-2">
                <span className="p-1.5 bg-emerald-500/10 text-emerald-400 rounded">
                  <Code size={18} />
                </span>
                <h3 className="font-semibold text-white text-lg">Keahlian & Kompetensi</h3>
              </div>
              <button
                onClick={addSkill}
                className="flex items-center gap-1.5 text-xs font-semibold bg-emerald-600 hover:bg-emerald-700 text-white transition-all rounded-lg px-3 py-1.5 cursor-pointer shadow-sm"
              >
                <Plus size={14} /> Tambah Keahlian
              </button>
            </div>

            {cvData.skills.length === 0 ? (
              <div className="text-center py-8 bg-[#13161c]/30 rounded-xl border border-dashed border-white/5">
                <Code className="mx-auto text-slate-600 mb-2" size={32} />
                <p className="text-sm text-slate-400">Belum ada keahlian ditambahkan.</p>
                <button
                  onClick={addSkill}
                  className="mt-3 text-xs font-semibold text-emerald-450 hover:underline inline-flex items-center gap-1 cursor-pointer"
                >
                  <Plus size={14} /> Tambah Sekarang
                </button>
              </div>
            ) : (
              <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                {cvData.skills.map((skill, index) => (
                  <div key={index} className="flex flex-col p-3.5 border border-white/5 rounded-xl bg-[#13161c]/40 space-y-3 relative hover:border-emerald-500/20 transition-all">
                    <button
                      onClick={() => removeSkill(index)}
                      className="absolute top-2 right-2 text-slate-500 hover:text-rose-455 transition-all cursor-pointer p-1"
                      title="Hapus Keahlian"
                    >
                      <Trash2 size={14} />
                    </button>

                    <div>
                      <label className="block text-[10px] font-bold text-slate-400 uppercase tracking-wide mb-1">Nama Skill</label>
                      <input
                        type="text"
                        value={skill.name}
                        onChange={(e) => updateSkill(index, "name", e.target.value)}
                        className="w-full px-2.5 py-1 bg-[#13161c] border border-white/10 rounded-lg text-xs text-slate-100 focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-transparent transition-all placeholder-slate-600"
                        placeholder="React.js / Google Ads / Kepemimpinan"
                      />
                    </div>

                    <div className="grid grid-cols-2 gap-2">
                      <div>
                        <label className="block text-[10px] font-bold text-slate-400 uppercase tracking-wide mb-1">Level ({skill.level}%)</label>
                        <input
                          type="range"
                          min="10"
                          max="100"
                          step="5"
                          value={skill.level}
                          onChange={(e) => updateSkill(index, "level", parseInt(e.target.value))}
                          className="w-full h-1.5 bg-[#13161c] border border-white/10 rounded-lg appearance-none cursor-pointer accent-emerald-500"
                        />
                      </div>
                      <div>
                        <label className="block text-[10px] font-bold text-slate-400 uppercase tracking-wide mb-1">Kategori</label>
                        <select
                          value={skill.category}
                          onChange={(e) => updateSkill(index, "category", e.target.value)}
                          className="w-full px-2 py-1 text-xs bg-[#13161c] border border-white/10 rounded-lg text-slate-200 focus:outline-none focus:ring-1 focus:ring-emerald-500"
                        >
                          <option value="Technical" className="bg-[#13161c] text-white">Teknis (Hard Skill)</option>
                          <option value="Soft Skill" className="bg-[#13161c] text-white">Interpersonal (Soft)</option>
                          <option value="Language" className="bg-[#13161c] text-white">Bahasa</option>
                        </select>
                      </div>
                    </div>
                  </div>
                ))}
              </div>
            )}
          </div>
        )}

        {/* PROJECTS */}
        {activeTab === "projects" && (
          <div className="space-y-4" id="form-section-projects">
            <div className="flex items-center justify-between pb-2 border-b border-white/5">
              <div className="flex items-center gap-2">
                <span className="p-1.5 bg-emerald-500/10 text-emerald-400 rounded">
                  <FolderGit size={18} />
                </span>
                <h3 className="font-semibold text-white text-lg">Portofolio & Produk</h3>
              </div>
              <button
                onClick={addProject}
                className="flex items-center gap-1.5 text-xs font-semibold bg-emerald-600 hover:bg-emerald-700 text-white transition-all rounded-lg px-3 py-1.5 cursor-pointer shadow-sm"
              >
                <Plus size={14} /> Tambah Projek
              </button>
            </div>

            {cvData.projects.length === 0 ? (
              <div className="text-center py-8 bg-[#13161c]/30 rounded-xl border border-dashed border-white/5">
                <FolderGit className="mx-auto text-slate-600 mb-2" size={32} />
                <p className="text-sm text-slate-400">Belum ada deskripsi projek ditambahkan.</p>
                <button
                  onClick={addProject}
                  className="mt-3 text-xs font-semibold text-emerald-450 hover:underline inline-flex items-center gap-1 cursor-pointer"
                >
                  <Plus size={14} /> Tambah Sekarang
                </button>
              </div>
            ) : (
              <div className="space-y-6">
                {cvData.projects.map((proj, index) => (
                  <div key={proj.id} className="relative p-5 border border-white/5 rounded-xl bg-[#13161c]/40 space-y-4 shadow-sm hover:border-emerald-500/20 transition-all">
                    <button
                      onClick={() => removeProject(proj.id)}
                      className="absolute top-4 right-4 text-slate-500 hover:text-rose-450 transition-all cursor-pointer p-1 rounded-md hover:bg-rose-955/20"
                      title="Hapus Projek"
                    >
                      <Trash2 size={16} />
                    </button>

                    <div className="text-xs font-bold text-emerald-400 bg-emerald-500/10 px-2 py-0.5 rounded w-max">
                      Projek {index + 1}
                    </div>

                    <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                      <div>
                        <label className="block text-xs font-semibold text-slate-400 tracking-wider uppercase mb-1">Judul Projek</label>
                        <input
                          type="text"
                          value={proj.title}
                          onChange={(e) => updateProject(proj.id, "title", e.target.value)}
                          className="w-full px-3 py-1.5 bg-[#13161c] border border-white/10 rounded-lg text-sm text-slate-100 focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-transparent transition-all placeholder-slate-600"
                          placeholder="Website LDK Syahid / Toko Online"
                        />
                      </div>
                      <div>
                        <label className="block text-xs font-semibold text-slate-400 tracking-wider uppercase mb-1">Peran Anda</label>
                        <input
                          type="text"
                          value={proj.role}
                          onChange={(e) => updateProject(proj.id, "role", e.target.value)}
                          className="w-full px-3 py-1.5 bg-[#13161c] border border-white/10 rounded-lg text-sm text-slate-100 focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-transparent transition-all placeholder-slate-600"
                          placeholder="Lead Developer / UI Designer"
                        />
                      </div>
                      <div className="md:col-span-2">
                        <label className="block text-xs font-semibold text-slate-400 tracking-wider uppercase mb-1">Keahlian / Teknologi (Pisahkan dengan koma)</label>
                        <input
                          type="text"
                          value={proj.technologies.join(", ")}
                          onChange={(e) => {
                            const arr = e.target.value.split(",").map((s) => s.trim());
                            updateProject(proj.id, "technologies", arr);
                          }}
                          className="w-full px-3 py-1.5 bg-[#13161c] border border-white/10 rounded-lg text-sm text-slate-100 focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-transparent transition-all placeholder-slate-600"
                          placeholder="React, TypeScript, Express, PostgreSQL"
                        />
                      </div>
                      <div className="md:col-span-2">
                        <label className="block text-xs font-semibold text-slate-400 tracking-wider uppercase mb-1">Tautan Projek / Demo</label>
                        <input
                          type="text"
                          value={proj.link}
                          onChange={(e) => updateProject(proj.id, "link", e.target.value)}
                          className="w-full px-3 py-1.5 bg-[#13161c] border border-white/10 rounded-lg text-sm text-slate-100 focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-transparent transition-all placeholder-slate-600"
                          placeholder="https://github.com/... atau https://ldksyah.id"
                        />
                      </div>
                      <div className="md:col-span-2">
                        <label className="block text-xs font-semibold text-slate-400 tracking-wider uppercase mb-1">Deskripsi Projek & Pencapaian</label>
                        <textarea
                          rows={3}
                          value={proj.description}
                          onChange={(e) => updateProject(proj.id, "description", e.target.value)}
                          className="w-full p-3 bg-[#13161c] border border-white/10 rounded-lg text-sm text-slate-100 focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-transparent transition-all leading-relaxed placeholder-slate-650"
                          placeholder="Jelaskan kontribusi Anda, tantangan yang dihadapi, dan hasil yang diperoleh pelajari..."
                        />
                      </div>
                    </div>
                  </div>
                ))}
              </div>
            )}
          </div>
        )}
      </div>
    </div>
  );
}
