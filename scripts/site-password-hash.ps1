# Generates a PHP password hash locally; does not connect to a database.
$ErrorActionPreference = 'Stop'
$php = Get-Command php -CommandType Application -ErrorAction Stop
$hashScript = Join-Path $PSScriptRoot 'site-password-hash.php'
$securePassword = Read-Host 'Senha do administrador (pelo menos 12 caracteres)' -AsSecureString
$pointer = [Runtime.InteropServices.Marshal]::SecureStringToBSTR($securePassword)
try {
    $plainPassword = [Runtime.InteropServices.Marshal]::PtrToStringBSTR($pointer)
    if ($plainPassword.Length -lt 12) { throw 'Use uma senha com pelo menos 12 caracteres.' }
    $previousEncoding = $OutputEncoding
    try {
        $OutputEncoding = [Text.UTF8Encoding]::new($false)
        $plainPassword | & $php.Source $hashScript
    } finally { $OutputEncoding = $previousEncoding }
    if ($LASTEXITCODE -ne 0) { throw "Falha ao gerar o hash (PHP retornou $LASTEXITCODE)." }
} finally {
    [Runtime.InteropServices.Marshal]::ZeroFreeBSTR($pointer)
    $plainPassword = $null
    $securePassword.Dispose()
}
