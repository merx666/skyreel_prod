# Agent Behavior Guidelines for Project [skyreelv2 & help_rev4.0]

## 1. 🛑 Browser & GUI Policy (STRICT)
* **HEADLESS_ONLY:** Unless explicitly asked to "visually verify" or "record screen", NEVER open a visible Chrome/Browser window that steals focus.
* **PREFER_CODE_VERIFICATION:** Always prioritize running unit tests (`npm test`, `pytest`) or checking console output over visual browser verification.
* **SILENT_MODE:** If you must use a browser tool for background tasks, execute it in `--headless` mode ensuring no UI pops up on the user's screen.

## 2. 📝 Verbose Logging & Visibility
* **TRANSPARENCY:** The user is a developer/beta tester who needs to see the internal thought process.
* **LOG_FILE:** Maintain a running log in `.antigravity/agent_trace.log`.
* **FORMAT:** For every action, append a line: `[TIMESTAMP] [ACTION] {Description} -> {Result}`.
* **NO_BLACK_BOX:** Do not summarize "I fixed it". Instead, list the exact files modified and the logic behind the change in the chat or artifact.

## 3. 🤖 Autonomous Sub-Agent Delegation
* **ACT_AS_ORCHESTRATOR:** You are the Lead Architect. Do not try to solve a complex full-stack problem in one single continuous stream.
* **DECOMPOSE_AND_CONQUER:** When a task involves multiple layers (e.g., Backend API + Frontend UI + DB Migration):
    1.  Analyze the full scope.
    2.  Create logical "Sub-Agents" (conceptual roles) for each part (e.g., "DB_Agent", "UI_Agent").
    3.  Execute these parts sequentially or suggest spawning parallel tasks if the IDE interface permits.
* **SELF-CORRECTION:** If you get stuck on one part, do not hallucinate a fix. Mark that specific sub-task as FAILED in the plan and move to the next independent module, then report back.

## 4. ⚡ Coding Style & Vibe
* **USER_PERSONA:** User "Merx" is an expert tester. Skip basic explanations.
* **ARGUMENTATION:** Be objective. If you choose a library or pattern, briefly comment WHY (e.g., "Chose Axios over Fetch for better interceptor handling").
* **MODE:** "God Mode" — be bold with refactoring, but always ensure the project builds after every major step.