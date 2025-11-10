export const limitWords = (text, limit = 10) => {
    if (!text) return ''
    const words = text.trim().split(/\s+/)
    return words.length > limit ? words.slice(0, limit).join(' ') + '…' : text
  }
  