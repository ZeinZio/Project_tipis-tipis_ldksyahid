var __create = Object.create;
var __defProp = Object.defineProperty;
var __getOwnPropDesc = Object.getOwnPropertyDescriptor;
var __getOwnPropNames = Object.getOwnPropertyNames;
var __getProtoOf = Object.getPrototypeOf;
var __hasOwnProp = Object.prototype.hasOwnProperty;
var __copyProps = (to, from, except, desc) => {
  if (from && typeof from === "object" || typeof from === "function") {
    for (let key of __getOwnPropNames(from))
      if (!__hasOwnProp.call(to, key) && key !== except)
        __defProp(to, key, { get: () => from[key], enumerable: !(desc = __getOwnPropDesc(from, key)) || desc.enumerable });
  }
  return to;
};
var __toESM = (mod, isNodeMode, target) => (target = mod != null ? __create(__getProtoOf(mod)) : {}, __copyProps(
  // If the importer is in node compatibility mode or this is not an ESM
  // file that has been converted to a CommonJS file using a Babel-
  // compatible transform (i.e. "__esModule" has not been set), then set
  // "default" to the CommonJS "module.exports" for node compatibility.
  isNodeMode || !mod || !mod.__esModule ? __defProp(target, "default", { value: mod, enumerable: true }) : target,
  mod
));

// server.ts
var import_express = __toESM(require("express"), 1);
var import_path = __toESM(require("path"), 1);
var import_vite = require("vite");
var import_genai = require("@google/genai");
var import_dotenv = __toESM(require("dotenv"), 1);
import_dotenv.default.config();
async function startServer() {
  const app = (0, import_express.default)();
  const PORT = 3e3;
  app.use(import_express.default.json({ limit: "50mb" }));
  app.post("/api/gemini/enhance", async (req, res) => {
    try {
      const { text, section } = req.body;
      if (!text) {
        return res.status(400).json({ error: "Text is required" });
      }
      if (!process.env.GEMINI_API_KEY) {
        return res.status(500).json({
          error: "GEMINI_API_KEY is not configured. Please add it in the Secrets panel."
        });
      }
      const ai = new import_genai.GoogleGenAI({
        apiKey: process.env.GEMINI_API_KEY,
        httpOptions: {
          headers: {
            "User-Agent": "aistudio-build"
          }
        }
      });
      let systemPrompt = "You are an expert Indonesian-English tech recruiter and professional resume writer. Your job is to improve the provided resume text to be more impact-driven, professional, clean, and impressive. Keep the language natural, matching the language of the input (if the input is in Indonesian, respond in Indonesian; if English, respond in English). Focus on action verbs, metrics, and outcomes.";
      if (section === "summary") {
        systemPrompt += " Write a compelling professional summary/bio (about 2-4 sentences) that highlights the candidate's core strengths, experience, and professional drive. Do not write generic text.";
      } else if (section === "experience" || section === "project") {
        systemPrompt += " Rephrase this into strong, result-oriented bullet points (using the STAR method: Situation, Task, Action, Result where possible) with clear action verbs. Do not add intro/outro comments. Just output the refined bullet points. Write each bullet point starting with a dash or dot.";
      } else {
        systemPrompt += " Refine the text to be grammatically correct, professional, and clear.";
      }
      const response = await ai.models.generateContent({
        model: "gemini-3.5-flash",
        contents: `Improve the following text for a resume/portfolio. Text: "${text}"`,
        config: {
          systemInstruction: systemPrompt,
          temperature: 0.7
        }
      });
      const enhancedText = response.text || "";
      res.json({ enhancedText });
    } catch (error) {
      console.error("Gemini enhance error:", error);
      res.status(500).json({ error: error.message || "Failed to enhance text" });
    }
  });
  app.post("/api/gemini/chat", async (req, res) => {
    try {
      const { messages, cvData } = req.body;
      if (!messages || !cvData) {
        return res.status(400).json({ error: "Messages and CV data are required" });
      }
      if (!process.env.GEMINI_API_KEY) {
        return res.status(500).json({
          error: "GEMINI_API_KEY is not configured. Please add it in the Secrets panel."
        });
      }
      const ai = new import_genai.GoogleGenAI({
        apiKey: process.env.GEMINI_API_KEY,
        httpOptions: {
          headers: {
            "User-Agent": "aistudio-build"
          }
        }
      });
      const context = `
Candidate Profile Context:
Name: ${cvData.personalInfo?.fullName || "Candidate"}
Title: ${cvData.personalInfo?.jobTitle || "Developer"}
Email: ${cvData.personalInfo?.email || ""}
Phone: ${cvData.personalInfo?.phone || ""}
Location: ${cvData.personalInfo?.location || ""}
About/Summary: ${cvData.personalInfo?.summary || ""}

Social Links:
LinkedIn: ${cvData.socialLinks?.linkedin || "N/A"}
GitHub: ${cvData.socialLinks?.github || "N/A"}
WhatsApp: ${cvData.socialLinks?.whatsapp || "N/A"}
Website: ${cvData.socialLinks?.website || "N/A"}

Work Experience:
${(cvData.experience || []).map((exp) => `- ${exp.role} at ${exp.company} (${exp.duration}), Location: ${exp.location || "Remote"}. Description: ${exp.description}`).join("\n")}

Projects:
${(cvData.projects || []).map((proj) => `- ${proj.name} (${proj.date}): ${proj.description}. Technologies: ${proj.tags?.join(", ") || "N/A"}. Live URL: ${proj.liveUrl || "N/A"}`).join("\n")}

Skills:
${(cvData.skills || []).map((skill) => `- ${skill.name} (${skill.category || "General"}): Level ${skill.level}%`).join("\n")}

Education:
${(cvData.education || []).map((edu) => `- ${edu.degree} from ${edu.institution} (${edu.duration}), Grade/GPA: ${edu.grade || "N/A"}`).join("\n")}
`;
      const systemInstruction = `
You are an enthusiastic, professional, and friendly AI Assistant representing ${cvData.personalInfo?.fullName || "the candidate"}.
Your purpose is to help recruiters, potential clients, and website visitors learn more about the candidate's professional background, projects, skills, and experience.

Guidelines:
1. Speak in a highly professional, polite, and persuasive recruiter-friendly tone. Speak like a personal agent of the candidate.
2. Answer questions accurately based on the Candidate Profile Context provided below.
3. If asked about something not present in the context (e.g., specific hobbies or unrelated information), politely explain that you do not have that exact detail, and guide the recruiter back to their core strengths and skills.
4. Respond in the same language as the recruiter's message (e.g. Indonesian or English). If they ask in Indonesian, answer in Indonesian.
5. Keep your answers concise, structured (using bold headings or bullet points where appropriate), and polite.
6. Absolutely DO NOT make up fake credentials or experience. Be honest but positive.

Candidate Profile Context:
${context}
`;
      const contents = messages.map((m) => {
        return {
          role: m.role === "user" ? "user" : "model",
          parts: [{ text: m.content }]
        };
      });
      const response = await ai.models.generateContent({
        model: "gemini-3.5-flash",
        contents,
        config: {
          systemInstruction,
          temperature: 0.7
        }
      });
      const reply = response.text || "";
      res.json({ reply });
    } catch (error) {
      console.error("Gemini chat error:", error);
      res.status(500).json({ error: error.message || "Failed to generate chat reply" });
    }
  });
  if (process.env.NODE_ENV !== "production") {
    const vite = await (0, import_vite.createServer)({
      server: { middlewareMode: true },
      appType: "spa"
    });
    app.use(vite.middlewares);
  } else {
    const distPath = import_path.default.join(process.cwd(), "dist");
    app.use(import_express.default.static(distPath));
    app.get("*", (req, res) => {
      res.sendFile(import_path.default.join(distPath, "index.html"));
    });
  }
  app.listen(PORT, "0.0.0.0", () => {
    console.log(`Server running on http://0.0.0.0:${PORT}`);
  });
}
startServer();
//# sourceMappingURL=server.cjs.map
