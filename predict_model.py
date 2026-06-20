import sys
import pickle
import re

# ============================================
# LOAD THE MODEL AND VECTORIZER
# ============================================
try:
    model = pickle.load(open('model.pkl', 'rb'))
    vectorizer = pickle.load(open('vectorizer2.pkl', 'rb'))
except FileNotFoundError as e:
    print(f"FILE NOT FOUND: {e}", file=sys.stderr)
    print("Uncategorized,0")
    sys.exit(1)
except Exception as e:
    print(f"LOAD ERROR: {e}", file=sys.stderr)
    print("Uncategorized,0")
    sys.exit(1)

# ============================================
# GET THE TASK TITLE FROM PHP
# ============================================
if len(sys.argv) < 2:
    print("Uncategorized,0")
    sys.exit(1)

task_title = sys.argv[1]
task_title = re.sub(r'\s+', ' ', task_title).strip().lower()

# ============================================
# PREDICT THE CATEGORY
# ============================================
try:
    X = vectorizer.transform([task_title])
    prediction = model.predict(X)[0]
    probabilities = model.predict_proba(X)[0]
    confidence = max(probabilities) * 100
    print(f"{prediction},{confidence:.1f}")
except Exception as e:
    print(f"PREDICTION ERROR: {e}", file=sys.stderr)
    print("Uncategorized,0")