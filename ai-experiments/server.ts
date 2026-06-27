import express from "express";
import path from "path";
import { createServer as createViteServer } from "vite";
import { GoogleGenAI, Type } from "@google/genai";
import dotenv from "dotenv";

dotenv.config();

const app = express();
const PORT = 3000;

// Initialize GoogleGenAI with server-side API Key & Telemetry User-Agent
const apiKey = process.env.GEMINI_API_KEY || "";
const ai = new GoogleGenAI({
  apiKey: apiKey,
  httpOptions: {
    headers: {
      "User-Agent": "aistudio-build",
    },
  },
});

app.use(express.json({ limit: "50mb" }));

// ATS CV & Portfolio Checker API
app.post("/api/ats-check", async (req, res) => {
  try {
    const { cvData, targetTitle, targetDescription } = req.body;

    if (!cvData) {
      return res.status(400).json({ error: "CV data is required" });
    }

    if (!apiKey) {
      return res.status(500).json({
        error: "Gemini API key is not configured. Please supply GEMINI_API_KEY in Settings > Secrets.",
      });
    }

    // Prepare prompt
    const prompt = `
Anda adalah seorang Ahli Rekrutmen Profesional dan Spesialis Sistem ATS (Applicant Tracking System) Internasional yang biasa menangani CV, resume, dan portofolio kerja.
Tugas Anda adalah melakukan audit mendalam terhadap CV/Resume yang diberikan dan membandingkannya dengan Judul Pekerjaan Target ("${targetTitle || "Umum/General"}") serta Deskripsi Pekerjaan Target ("${targetDescription || "Tidak dicantumkan"}").

Berikan umpan balik yang komprehensif, mendalam, dan taktis dalam format JSON terstruktur untuk membuat CV ini sangat 'ATS Friendly' dan meningkatkan peluang lolos verifikasi awal rekrutmen. Hubungkan juga dengan keunggulan portofolio milik pelamar.

Berikut adalah data CV pelamar saat ini:
${JSON.stringify(cvData, null, 2)}

Ketentuan analisis:
1. Hitung score akhir kelayakan ATS (0-100), keywordScore (0-100), formattingScore (0-100), dan impactScore (0-100) berdasarkan kesesuaian dengan deskripsi pekerjaan.
2. Identifikasi kata kunci penting (matchedKeywords) yang sudah ada di CV yang cocok dengan deskripsi pekerjaan.
3. Temukan kata kunci vital yang hilang (missingKeywords) yang seharusnya dimasukkan ke dalam pengalaman kerja atau keahlian pelamar.
4. Periksa komponen struktural (struktur & keterbacaan, penggunaan kata kerja aksi modern, bagian kontak, dll) dan berikan catatan detail dalam 'structureFeedback' dengan status "success", "warning", atau "danger".
5. Berikan minimal 3-5 saran rekonstruksi penulisan spesifik ('improvements') yang mengubah kalimat biasa/klise pelamar menjadi kalimat berorientasi hasil yang bisa diukur (quantified impact) menggunakan rumus STAR (Situation, Task, Action, Result) dalam bahasa Indonesia yang sangat profesional dan elegan.
6. Berikan contoh penulisan ulang 'Tentang Saya' atau 'Ringkasan Profil' (summaryRewrite) yang luar biasa menarik, ATS-Friendly, dan bermagnet tinggi bagi HRD, berfokus pada target pekerjaan ini.
7. Rekomendasikan keahlian (suggestedSkills) yang relevan untuk ditambahkan ke profil.

Harap berikan respon dalam format JSON yang bersih dan valid.
`;

    const response = await ai.models.generateContent({
      model: "gemini-3.5-flash",
      contents: prompt,
      config: {
        responseMimeType: "application/json",
        responseSchema: {
          type: Type.OBJECT,
          required: [
            "score",
            "keywordScore",
            "formattingScore",
            "impactScore",
            "matchedKeywords",
            "missingKeywords",
            "structureFeedback",
            "improvements",
            "summaryRewrite",
            "suggestedSkills",
          ],
          properties: {
            score: {
              type: Type.INTEGER,
              description: "Skor keseluruhan keselarasan ATS dari 0 sampai 100.",
            },
            keywordScore: {
              type: Type.INTEGER,
              description: "Skor kecocokan kata kunci dari 0 sampai 100.",
            },
            formattingScore: {
              type: Type.INTEGER,
              description: "Skor format & struktur CV dari 0 sampai 100.",
            },
            impactScore: {
              type: Type.INTEGER,
              description: "Skor keterukuran dampak pencapaian dari 0 sampai 100.",
            },
            matchedKeywords: {
              type: Type.ARRAY,
              items: { type: Type.STRING },
              description: "Daftar kata kunci penting yang sudah ditemukan di CV.",
            },
            missingKeywords: {
              type: Type.ARRAY,
              items: { type: Type.STRING },
              description: "Daftar kata kunci penting dari deskripsi kerja yang belum ada di CV.",
            },
            structureFeedback: {
              type: Type.ARRAY,
              description: "Analisis format, layout, jenis huruf, kepatuhan struktur.",
              items: {
                type: Type.OBJECT,
                required: ["criteria", "status", "message"],
                properties: {
                  criteria: { type: Type.STRING, description: "Kriteria penilaian, misal: 'Gaya Bahasa', 'Detail Kontak'" },
                  status: { 
                    type: Type.STRING, 
                    enum: ["success", "warning", "danger"],
                    description: "Status evaluasi." 
                  },
                  message: { type: Type.STRING, description: "Catatan penjelasan detail." },
                },
              },
            },
            improvements: {
              type: Type.ARRAY,
              description: "Saran penulisan ulang poin CV menggunakan STAR method.",
              items: {
                type: Type.OBJECT,
                required: ["section", "originalText", "suggestedText"],
                properties: {
                  section: { type: Type.STRING, description: "Bagian CV, misal: 'Pengalaman', 'Projek'." },
                  originalText: { type: Type.STRING, description: "Teks lama yang kurang kuat." },
                  suggestedText: { type: Type.STRING, description: "Saran perubahan teks baru yang mengandung hasil terukur (metrics/numbers) dan kata kerja kuat." },
                },
              },
            },
            summaryRewrite: {
              type: Type.STRING,
              description: "Saran penulisan ulang ringkasan profil profesional pelamar.",
            },
            suggestedSkills: {
              type: Type.ARRAY,
              items: { type: Type.STRING },
              description: "Daftar skill pelengkap yang disarankan untuk ditambahkan.",
            },
          },
        },
      },
    });

    const parsedData = JSON.parse(response.text || "{}");
    res.json(parsedData);
  } catch (error) {
    console.error("Error evaluating ATS:", error);
    res.status(500).json({
      error: "Gagal menganalisis CV dengan AI. Harap periksa apakah API Key Anda valid.",
      details: error instanceof Error ? error.message : String(error),
    });
  }
});

// Setup development or production environment
async function setupServer() {
  if (process.env.NODE_ENV !== "production") {
    // Mount Vite dev server in middleware mode
    const vite = await createViteServer({
      server: { middlewareMode: true },
      appType: "spa",
    });
    app.use(vite.middlewares);
  } else {
    // Serve static files in production
    const distPath = path.join(process.cwd(), "dist");
    app.use(express.static(distPath));
    app.get("*", (req, res) => {
      res.sendFile(path.join(distPath, "index.html"));
    });
  }

  app.listen(PORT, "0.0.0.0", () => {
    console.log(`Server is running at http://localhost:${PORT}`);
  });
}

setupServer();
