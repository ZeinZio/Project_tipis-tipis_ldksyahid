import { CVData } from "./types";

export const initialCVData: CVData = {
  personalInfo: {
    fullName: "Zio Raines",
    title: "Software Engineer & Web Developer",
    email: "zioraines04@gmail.com",
    phone: "+62 812-3456-7890",
    location: "Jakarta, Indonesia",
    website: "https://zioraines.dev",
    github: "https://github.com/zioraines",
    linkedin: "https://linkedin.com/in/zioraines",
    about: "Mahasiswa Informatika yang berdedikasi tinggi dengan fokus pada pengembangan Web Full-stack dan rekayasa perangkat lunak. Aktif berkontribusi dalam digitalisasi organisasi kampus, termasuk merancang portal digital interaktif untuk LDK Syahid UIN Jakarta. Menyukai pemecahan masalah teknis dengan teknologi Next.js, Express, dan sistem cerdas berbasis AI.",
  },
  workExperience: [
    {
      id: "work-1",
      position: "Full Stack Web Developer Intern",
      company: "PT Digital Solusi Nusantara",
      period: "Jul 2025 - Mar 2026",
      location: "Jakarta, Indonesia",
      description: "• Membangun dan memelihara aplikasi web internal menggunakan React.js dan Node.js.\n• Berkolaborasi dengan tim UI/UX untuk menerapkan desain responsif yang meningkatkan kepuasan pengguna sebesar 25%.\n• Mengembangkan RESTful API dengan Express untuk modul transaksi keuangan.\n• Melakukan debugging dan optimasi performa backend, memangkas latency kueri database sebesar 15%.",
    },
    {
      id: "work-2",
      position: "Koordinator Tim IT & Digitalisasi",
      company: "LDK Syahid UIN Syarif Hidayatullah",
      period: "Jan 2025 - Sekarang",
      location: "Tangerang Selatan, Banten",
      description: "• Memimpin tim IT beranggotakan 6 orang untuk mengelola seluruh infrastruktur media digital dan server organisasi.\n• Merancang ulang landing page official LDK Syahid (ldksyah.id) dengan optimasi SEO modern, meningkatkan kunjungan organik harian hingga 40%.\n• Mengembangkan sistem manajemen pendaftaran anggota baru (Dauroh) berbasis web yang sukses memproses lebih dari 500 pendaftar secara otomatis.\n• Mengintegrasikan database panitia untuk efisiensi distribusi laporan kerja bulanan.",
    },
  ],
  education: [
    {
      id: "edu-1",
      institution: "UIN Syarif Hidayatullah Jakarta",
      degree: "S1 Teknik Informatika",
      period: "2022 - Sekarang",
      gpa: "3.82 / 4.00",
      description: "Fokus pada Rekayasa Perangkat Lunak, Struktur Data, dan Sistem Basis Data. Aktif dalam organisasi kemahasiswaan dan proyek lab komputasi.",
    },
  ],
  skills: [
    { name: "TypeScript", level: 90, category: "Technical" },
    { name: "React.js", level: 92, category: "Technical" },
    { name: "Node.js & Express", level: 85, category: "Technical" },
    { name: "Tailwind CSS", level: 95, category: "Technical" },
    { name: "Next.js", level: 80, category: "Technical" },
    { name: "PostgreSQL & Firebase", level: 78, category: "Technical" },
    { name: "Git & GitHub", level: 88, category: "Technical" },
    { name: "Kepemimpinan Tim", level: 85, category: "Soft Skill" },
    { name: "Analisis Masalah", level: 90, category: "Soft Skill" },
    { name: "Bahasa Inggris", level: 75, category: "Language" },
  ],
  projects: [
    {
      id: "proj-1",
      title: "Sistem Administrasi Keanggotaan Digital",
      role: "Lead Developer",
      description: "Platform keanggotaan interaktif yang dilengkapi pelacakan kehadiran rapat, penyimpanan arsip dokumen, dan visualisasi performa anggota.",
      technologies: ["React", "Express", "Tailwind CSS", "Chart.js"],
      link: "https://github.com/zioraines/keanggotaan-ldk",
    },
    {
      id: "proj-2",
      title: "Portal Informasi Event Kampus",
      role: "Full-stack Developer",
      description: "Sistem pendaftaran kegiatan seminar dengan integrasi pembayaran otomatis via Midtrans sandbox dan notifikasi email.",
      technologies: ["Next.js", "Firebase Auth", "PostgreSQL"],
      link: "https://github.com/zioraines/event-portal",
    },
  ],
};
