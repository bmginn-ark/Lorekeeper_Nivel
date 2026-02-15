# Lorekeeper_Nivel 폴더 이름 변경 및 Git 저장 안내

## 1. 폴더 이름 변경 (lorekeeper_aish → Lorekeeper_Nivel)

**중요:** Cursor(또는 이 프로젝트를 연 폴더)를 **닫은 뒤** 진행하는 것이 안전합니다.

### 방법 A – 탐색기에서 (권장)
1. Cursor에서 이 프로젝트 닫기 (File → Close Folder)
2. Windows 탐색기에서 `d:\00` 로 이동
3. `lorekeeper_aish` 폴더 우클릭 → **이름 바꾸기**
4. `Lorekeeper_Nivel` 로 입력 후 Enter
5. Cursor에서 **File → Open Folder** → `d:\00\Lorekeeper_Nivel` 선택

### 방법 B – PowerShell에서
1. Cursor에서 이 프로젝트 닫기
2. PowerShell 열고 아래 실행:
   ```powershell
   Rename-Item -Path "d:\00\lorekeeper_aish" -NewName "Lorekeeper_Nivel"
   ```
3. Cursor에서 `d:\00\Lorekeeper_Nivel` 폴더 열기

---

## 2. Git에 저장하기

폴더 이름을 바꾼 뒤, **새 폴더 경로**에서 터미널을 엽니다.

### 2-1. 현재 상태
- **origin**: 원본 Lorekeeper (https://github.com/corowne/lorekeeper.git)
- **live**: 라이브 서버용 원격 (arkyak.cafe24.com → ssh://root@arkyak.cafe24.com/var/arkyak.cafe24.com/site_hub.git)
- 로컬에 커밋은 많이 쌓여 있고, 수정·추가 파일이 있는 상태입니다.

### 2-2. 한 번에 커밋하고 푸시 (라이브 서버로)

```powershell
cd d:\00\Lorekeeper_Nivel

# 변경·추가 파일 모두 스테이징
git add -A

# 커밋 (메시지는 원하는 대로 수정)
git commit -m "Rename project to Lorekeeper_Nivel, include current customizations and ko.json"

# 라이브 서버 원격으로 푸시
git push live main
```

`main` 대신 라이브 서버에서 사용 중인 브랜치 이름이 있으면 그걸로 바꿉니다.

### 2-3. 본인 GitHub에도 백업/연동하고 싶을 때

1. GitHub에서 **새 저장소** 생성 (예: `Lorekeeper_Nivel`), README 추가 안 함.
2. 로컬에서 새 원격 추가 후 푸시:

   ```powershell
   cd d:\00\Lorekeeper_Nivel
   git remote add mygithub https://github.com/본인아이디/Lorekeeper_Nivel.git
   git push -u mygithub main
   ```

이후에는:
- 로컬 작업 → `git add` → `git commit` → `git push mygithub main` (백업)
- 라이브 반영 → `git push live main`

---

## 3. 라이브 서버와 Git 연동 (arkyak.cafe24.com)

**live** 원격이 arkyak.cafe24.com 라이브 서버의 `site_hub.git`을 가리킵니다.

- **로컬에서** `git push live main` 하면 → 코드가 라이브 서버 저장소로 올라갑니다.
- **라이브 서버에서** 실제 사이트 디렉터리가 이 저장소를 **clone** 했거나 **pull** 하도록 되어 있다면, 서버 쪽에서 다음만 하면 됩니다:

  ```bash
  cd /var/arkyak.cafe24.com/사이트디렉터리   # 실제 경로로 변경 (Cafe24 구조에 맞게)
  git pull
  # 필요 시: php artisan migrate, composer install 등
  ```

서버에 아직 Git으로 배포가 안 되어 있다면:
- 서버에 SSH 접속 후, 사이트 디렉터리를 `site_hub.git` clone 해 두거나
- 기존 디렉터리에서 `git init` 후 `remote add origin ...` 으로 `site_hub.git` 연결

**참고:** Cafe24 호스팅은 SSH/Git 지원 여부가 플랜에 따라 다릅니다. SSH 접근이 없다면 FTP 배포나 GitHub Actions 등을 활용하세요.

이후에는 **로컬에서 push → 서버에서 pull** 흐름으로 연동할 수 있습니다.

---

## 4. 요약

| 단계 | 내용 |
|------|------|
| 1 | Cursor 닫기 → `d:\00\lorekeeper_aish` 를 `Lorekeeper_Nivel` 로 이름 변경 → Cursor에서 새 폴더 열기 |
| 2 | `d:\00\Lorekeeper_Nivel` 에서 `git add -A` → `git commit` → `git push live main` |
| 3 | (선택) 본인 GitHub 저장소 추가 후 `git push mygithub main` 으로 백업 |
| 4 | 라이브 서버(arkyak.cafe24.com)는 **live** 원격으로 연동; 서버에서는 `git pull` 로 반영 |

폴더 이름은 로컬/탐색기 이름만 바뀌는 것이고, Git 저장소 내용(히스토리, 원격)은 그대로 유지됩니다.
