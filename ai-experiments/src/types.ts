export interface PersonalInfo {
  fullName: string;
  title: string;
  email: string;
  phone: string;
  location: string;
  website: string;
  github: string;
  linkedin: string;
  about: string;
}

export interface WorkExperience {
  id: string;
  position: string;
  company: string;
  period: string;
  description: string;
  location: string;
}

export interface Education {
  id: string;
  institution: string;
  degree: string;
  period: string;
  gpa: string;
  description: string;
}

export interface Skill {
  name: string;
  level: number; // 0-100 for web portfolio visualization
  category: string; // e.g., "Technical", "Soft Skill", "Language"
}

export interface Project {
  id: string;
  title: string;
  role: string;
  description: string;
  technologies: string[];
  link: string;
}

export interface CVData {
  personalInfo: PersonalInfo;
  workExperience: WorkExperience[];
  education: Education[];
  skills: Skill[];
  projects: Project[];
}

export interface ATSFeedback {
  score: number;
  keywordScore: number;
  formattingScore: number;
  impactScore: number;
  matchedKeywords: string[];
  missingKeywords: string[];
  structureFeedback: {
    criteria: string;
    status: "success" | "warning" | "danger";
    message: string;
  }[];
  improvements: {
    section: string;
    originalText: string;
    suggestedText: string;
  }[];
  summaryRewrite: string;
  suggestedSkills: string[];
}
