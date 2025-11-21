export const limitWords = (text, limit = 10) => {
    if (!text) return ''
    const words = text.trim().split(/\s+/)
    return words.length > limit ? words.slice(0, limit).join(' ') + '…' : text
  }
  
  export function smartWordwrap(str, width = 75, breakStr = "\n") {
    // Pattern for words longer than width
    const pattern = new RegExp(`([^ ]{${width},})`, "g");

    let output = "";
    let words = str.split(pattern);

    words.forEach(word => {
        if (word.includes(" ")) {
            // Normal words: append
            output += word;
        } else {
            // Long unbroken word
            const wrappedLines = output.split(breakStr);
            const lastLine = wrappedLines[wrappedLines.length - 1];
            const count = width - (lastLine.length % width);

            // Fill current line
            output += word.substring(0, count) + breakStr;

            // Wrap remaining part of long word
            const remaining = word.substring(count);
            output += wrapLongWord(remaining, width, breakStr);
        }
    });

    return finalWrap(output, width, breakStr);
}

// Helper: break long word into chunks
function wrapLongWord(str, width, breakStr) {
    let result = "";
    for (let i = 0; i < str.length; i += width) {
        result += str.substring(i, i + width) + breakStr;
    }
    return result;
}

// Final wrap using normal behavior
function finalWrap(str, width, breakStr) {
    const regex = new RegExp(`(.{1,${width}})( +|$)`, "g");
    return str.match(regex).join(breakStr).trim();
}


export function formatUS(date) {
    const d = new Date(date);
    return d.toLocaleDateString("en-US", {
        year: "numeric",
        month: "short",
        day: "2-digit",
    });
}